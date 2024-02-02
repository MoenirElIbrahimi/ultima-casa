<?php
include_once("functions.php");
session_start();
$db = ConnectDB();

$relatieid = $_SESSION["rolID"];

$filter = 0;
$filterids = "";

if (isset($_POST['filter'])) {
    $filter = 1;
    $sql = "SELECT FKhuizenID AS huizenID
            FROM mijncriteria 
            LEFT JOIN huiscriteria ON huiscriteria.FKcriteriaID = mijncriteria.FKcriteriaID
            LEFT JOIN criteria ON criteria.ID = mijncriteria.FKcriteriaID
            WHERE (mijncriteria.FKrelatiesID = $relatieid) 
            GROUP BY huizenID
            HAVING SUM(IF(criteria.Type < 2, huiscriteria.Waarde BETWEEN mijncriteria.Van AND mijncriteria.Tem, mijncriteria.Van = huiscriteria.Waarde)) = COUNT(*)";
    $fids = $db->query($sql)->fetchAll();
    
    $filterids = array(-1);
    foreach ($fids as $filterid) {
        $filterids[] = $filterid["huizenID"];
    }
    $filterids = "(huizen.ID IN (" . implode(",", $filterids) . ")) AND ";
}

$sql = "SELECT huizen.ID AS HID,
               StartDatum,
               Straat,
               CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats
        FROM huizen 
        LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
        LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
        WHERE $filterids (IFNULL(StatusCode, 0) < 10) AND (huizen.ID NOT IN (SELECT FKhuizenID FROM biedingen WHERE FKrelatiesID = 673))
        GROUP BY huizen.ID"; 

$kopen = $db->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Mijn Ultima Casa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="ucstyle.css?<?= mt_rand() ?>">
</head>
<body>
    <div class="container">
        <form action="koopins.php" method="POST">   
            <table id="mijnkopen" class="koop">
                <tr>
                    <th colspan=3>
                        <h4>
                            <?php echo ($filter > 0) ? 'Geselecteerde' : 'Alle'; ?> beschikbare huizen
                        </h4>
                    </th>
                    <th class="button-column">
                        <button class="action-button" disabled>
                            <?php echo ($filter > 0) ? '<a href="koopplus.php?RID=' . $relatieid . '" title="Alle beschikbare huizen tonen.">&#x2610;</a>' : '<a href="koopplus.php?RID=' . $relatieid . '&filter" title="Alleen geselecteerde huizen tonen.">&#x2611;</a>'; ?>
                        </button>
                    </th>
                    <th>
                        <button class="action-button">
                            <a href="relatie.php?RID=<?php echo $relatieid; ?>" >Annuleren</a>
                        </button>
                    </th>
                </tr>

                <?php if (count($kopen) > 0): ?>
                    <tr>
                        <th>Te koop sinds</th>
                        <th>Straat</th>
                        <th>Plaats</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>

                    <?php foreach ($kopen as $tekoop): ?>
                        <?php
                        $sql = "SELECT IF(TYPE=1, Waarde, IF(Waarde > 0, 'Ja', 'Nee')) AS Waarde, Criterium, Type   
                                FROM huiscriteria
                                LEFT JOIN criteria ON criteria.ID = huiscriteria.FKcriteriaID
                                WHERE huiscriteria.FKhuizenID = " . $tekoop['HID'] . "
                                ORDER BY Volgorde";
                        
                        $criteria = $db->query($sql)->fetchAll();
                        ?>

                        <tr>
                            <td><?php echo $tekoop['StartDatum']; ?></td>
                            <td><?php echo $tekoop['Straat']; ?></td>
                            <td><?php echo $tekoop['Plaats']; ?></td>
                            <td>
                                <button type="button" class="action-button" <?php echo (count($criteria) < 1) ? 'disabled' : ''; ?>
                                    data-toggle="collapse" data-target="#acc_<?php echo $tekoop['HID']; ?>" 
                                    title="<?php echo (count($criteria) < 1) ? 'Er zijn geen details beschikbaar.' : 'Details.'; ?>">&nbsp;&#9660;&nbsp;
                                </button>
                            </td>
                            <td class="button-column">
                                <button type="submit" class="action-button" id="plus" name="plus" 
                                        value="<?php echo $tekoop['HID']; ?>" title="Dit huis toevoegen aan mijn lijst.">+</button>
                            </td>
                        </tr>

                        <tr>
                            <td colspan=5>
                                <div id="acc_<?php echo $tekoop['HID']; ?>" class="collapse">
                                    <div class="form-inline">
                                        <?php foreach ($criteria as $criterium): ?>
                                            <div class="form-group spacer-right">
                                                <?php echo $criterium["Criterium"] . ': <label>' . $criterium["Waarde"] .  '</label>'; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan=5>
                            Er staan geen huizen te koop die voldoen aan je zoekcriteria
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" value="<?php echo $relatieid; ?>" id="RID" name="RID">
        </form>
    </div>
</body>
</html>
