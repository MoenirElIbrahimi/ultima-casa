<?php

include_once("functions.php");
session_start();
// Controleer of de vereiste variabelen zijn ingesteld
if (isset($_POST["Email"]) && isset($_POST["Wachtwoord"])) {
    $email = $_POST["Email"];
    $ww = md5($_POST["Wachtwoord"]);

    $db = ConnectDB();
    $sql = "SELECT relaties.ID as RID,
                   rollen.Waarde as Rol,
                   Landingspagina 
              FROM relaties
         LEFT JOIN rollen
                ON relaties.FKrollenID = rollen.ID
             WHERE (Email = '$email') 
               AND (Wachtwoord = '$ww')";

    $inlog = $db->query($sql)->fetch();

    $_SESSION["rolID"] = $inlog['RID'];

    $redirect_url = 'index.php?NOAccount';
    if ($inlog) {
        $redirect_url = $inlog['Landingspagina'] . '?RID=' . $inlog['RID'];
    }

    echo '<META HTTP-EQUIV=REFRESH CONTENT="1; ' . $redirect_url . '">';
} else {
    // Als Email of Wachtwoord niet is ingesteld, doe hier iets (bijvoorbeeld geef een foutmelding weer).
    echo "Email en/of Wachtwoord niet ingesteld.";
}

?>
