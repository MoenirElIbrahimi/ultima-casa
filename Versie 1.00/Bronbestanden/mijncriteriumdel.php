<?php
include_once("functions.php");
session_start();
$db = ConnectDB();

$id = $_POST["del"];
$relatieID = $_SESSION["rolID"];

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
        <h3>Mijn zoekcriterium verwijderen</h3>

        <?php
        $sql = "DELETE
               FROM mijncriteria 
              WHERE ID = :id";

        if ($db->query($sql, ['id' => $id]) == true) {
            echo '<p>Het criterium is verwijderd.</p>';
        } else {
            echo '<p>Fout bij het verwijderen van het criterium.</p>
                  <p>' . $sql . '</p>';
        }
        ?>

        <br><br>
        <button class="action-button"><a href="relatie.php?RID=<?= $relatieID ?>" >Ok</a></button>
    </div>
</div>
</body>
</html>
