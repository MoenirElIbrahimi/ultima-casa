<?php

     include_once("functions.php");
     
     $email = '"' . $_GET["Email"] . '"'; 
     $ww = '"' . md5($_GET["Wachtwoord"]) . '"'; 
     
     $db = ConnectDB();
     $sql = "   SELECT relaties.ID as RID,
                       rollen.Waarde as Rol,
                       Landingspagina 
                  FROM relaties
             LEFT JOIN rollen
                    ON relaties.FKrollenID = rollen.ID
                 WHERE (Email = $email) 
                   AND (Wachtwoord = $ww)";
                   
     $inlog = $db->query($sql)->fetch();
     
     $redirect_url = 'index.php?NOAccount';
     if ($inlog)
     {    $redirect_url = $inlog['Landingspagina'] . '?RID=' . $inlog['RID'];
     }
     
     echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '. $redirect_url . '">';
     
?>