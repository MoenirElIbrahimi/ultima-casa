<?php
include_once("functions.php");

$db = ConnectDB();

$relatieID = $_POST["RID"];

$CrVanTem = "NULL";
$Van = "NULL";
$Tem = "NULL";
$vals = "";

if (isset($_POST['CrVanTem']) && (!empty($_POST['CrVanTem']))) {
    $CrVanTem = $_POST['CrVanTem'];

    if (isset($_POST['Van']) && (!empty($_POST['Van']))) {
        $Van = $_POST['Van'];
    }

    if (isset($_POST['Tem']) && (!empty($_POST['Tem']))) {
        $Tem = $_POST['Tem'];
    }

    $vals = '(' . $Van . ',' . $Tem . ',' . $relatieID . ',' . $CrVanTem . ')';
}

$CrJaNee = "NULL";
$Van = "NULL";
$Tem = "NULL";

if (isset($_POST['CrJaNee']) && (!empty($_POST['CrJaNee']))) {
    $CrJaNee = $_POST['CrJaNee'];

    if (isset($_POST['JaNee']) && (!empty($_POST['JaNee']))) {
        $Van = $_POST['JaNee'];
    }

    if ($vals != "") {
        $vals .= ",";
    }

    $vals .= '(' . $Van . ',' . $Tem . ',' . $relatieID . ',' . $CrJaNee . ')';
}
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
    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
        <h3>Mijn zoekcriterium wijzigen</h3>

        <?php
        if (($CrVanTem != "NULL") || ($CrJaNee != "NULL")) {
            $sql = "INSERT INTO mijncriteria (Van, Tem, FKrelatiesID, FKcriteriaID) VALUES $vals";

            if ($db->query($sql) == true) {
                echo '<p>De zoekcriteria zijn toegevoegd.</p>';
            } else {
                echo '<p>Fout bij het toevoegen van de zoekcriteria.</p>
                      <p>' . $sql . '</p>';
            }
        } else {
            echo '<p>Er zijn geen nieuwe zoekcriteria toegevoegd.</p>';
        }
        ?>

        <br><br>
        <button class="action-button"><a href="relatie.php?RID=<?= $relatieID ?>" >Ok</a></button>
    </div>
</div>
</body>
</html>
