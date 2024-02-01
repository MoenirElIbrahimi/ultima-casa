<?php
include_once("functions.php");

$relatieid = $_POST['RID'];

$filtered = 0;
$filter = "relaties.ID = " . $relatieid . " AND (StatusCode < 100)";
$datum = "";
$bod = "";
$zoek = "";
if (isset($_POST['Datum']) && !empty($_POST['Datum'])) {
    $datum = $_POST['Datum'];
    $filtered = 1;
};
if (isset($_POST['Bod']) && !empty($_POST['Bod'])) {
    $bod = $_POST['Bod'];
    $filtered = 1;
};
if (isset($_POST['Zoek']) && !empty($_POST['Zoek'])) {
    $zoek = $_POST['Zoek'];
    $filtered = 1;
};

if (!empty($datum)) {
    $filter .= " AND StartDatum > '" . $datum . "'";
};

if (!empty($bod)) {
    $filter .= " AND Bod > " . $bod;
};

if (!empty($zoek)) {
    $filter .= " AND CONCAT_WS('', StartDatum, Datum, Bod, Status, Straat, Postcode, Plaats) LIKE '%" . $zoek . "%'";
};

$db = ConnectDB();

$sql = "SELECT biedingen.ID as TKID,
                StartDatum,
                IF(Bod, Datum, '&nbsp;') AS Datum,
                CONCAT('&euro; ', Bod) AS Bod,
                Straat,
                CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats,
                Status, 
                biedingen.FKhuizenID AS HID,
                huizen.FKRelatiesID as RID
            FROM biedingen
        LEFT JOIN relaties ON relaties.ID = biedingen.FKRelatiesID 
        LEFT JOIN huizen on huizen.ID = biedingen.FKhuizenID
        LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
            WHERE " . $filter . "
        ORDER BY Datum";

$kopen = $db->query($sql)->fetchAll();

$sql = "SELECT huizen.ID as HID,
                StartDatum,
                Straat,
                CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats,
                Status,
                CONCAT('&euro; ', Max(Bod)) AS HoogsteBod,
                Status
            FROM huizen
        LEFT JOIN relaties ON relaties.ID = huizen.FKRelatiesID 
        LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
        LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
        WHERE relaties.ID = $relatieid
        GROUP BY huizen.ID
        ORDER BY StartDatum";

$verkopen = $db->query($sql)->fetchAll();

$sql = "SELECT mijncriteria.ID as CID, Criterium, Van, Tem, Type,
                IF (Type = 1, Concat(Van, ' t/m ', Tem),  IF (Van > 0, 'Ja', 'Nee')) AS Waarde
            FROM mijncriteria
        LEFT JOIN criteria ON criteria.ID = FKcriteriaID
            WHERE FKrelatiesID = $relatieid";

$criteria = $db->query($sql)->fetchAll();

$sql = "SELECT ID, 
                Naam, 
                Email, 
                Telefoon,
                Wachtwoord
            FROM relaties
            WHERE ID = " . $relatieid;

$gegevens = $db->query($sql)->fetch();

$sql = "SELECT relaties.ID AS MID
            FROM relaties
        LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
            WHERE Waarde BETWEEN 30 AND 39 
            LIMIT 1"; // de eerste makelaar van Ultima Casa

$makelaar = $db->query($sql)->fetch();
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
    <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
</head>

<body>
    <div class="container">
        <?php echo InlogKop($relatieid, "Mijn Ultima Casa", '<td>
                <button class="action-button" title="De makelaar een e-mail sturen."> 
                        <a href="maakmail.php?RID=' . $relatieid . '&FID=' . $relatieid . '&TID=' . $makelaar["MID"] . '">&#x2709;
                </button>
            </td>'); ?>

        <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#kopen">Huizen die ik wil kopen</a></li>
            <li><a data-toggle="tab" href="#mijncriteria">Zoekcriteria</a></li>
            <li><a data-toggle="tab" href="#verkopen">Huizen die ik te koop aanbied</a></li>
            <li><a data-toggle="tab" href="#account">Account</a></li>
        </ul>

        <div class="tab-content">
            <div id="kopen" class="tab-pane fade in active">
                <!-- De rest van de code voor het tabblad 'Huizen die ik wil kopen' -->
            </div>

            <div id="verkopen" class="tab-pane fade">
                <!-- De rest van de code voor het tabblad 'Huizen die ik te koop aanbied' -->
            </div>

            <div id="mijncriteria" class="tab-pane fade">
                <!-- De rest van de code voor het tabblad 'Zoekcriteria' -->
            </div>

            <div id="account" class="tab-pane fade">
                <!-- De rest van de code voor het tabblad 'Account' -->
            </div>
        </div>
    </div>
</body>

</html>
