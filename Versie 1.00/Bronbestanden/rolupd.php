<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $id = $_GET["ID"]; 
     $relatieID = $_GET["RID"]; 
     
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Admin</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                         <h3>Rol wijzigen</h3>';
     
     $sql = "   UPDATE rollen
                   SET Naam = '" . $_GET['Naam'] . "', 
                       Omschrijving = '" . $_GET['Omschrijving'] . "',
                       Landingspagina = '" . $_GET['Landingspagina'] . "',
                       Waarde = '" . $_GET['Waarde'] . "'
                 WHERE ID = $id";

     if ($db->query($sql) == true) 
     {    echo 'De rol is gewijzigd';
     }
     else
     {    echo 'Fout bij het wijzigen van de rol.<br><br>' . $sql;
     }
    
     echo               '<br><br>
                         <button class="action-button"><a href="admin.php?RID=' . $relatieID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>