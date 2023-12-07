<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["wis"]; 
     $relatieid = $_GET['RID'];
         
     $sql = "   SELECT Naam, Omschrijving, Waarde, Landingspagina
                  FROM rollen
                 WHERE ID = " . $ID;
     
     $gegevens = $db->query($sql)->fetch();

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
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4" id="details">
                         <h3>Roldetails</h3>
                         <div class="form-group">
                              <label for="Naam">Rol:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Naam"] . '" id="Naam" name="Naam" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Omschrijving">Omschrijving:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Omschrijving"] . '" id="Omschrijving" name="Omschrijving" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Waarde">Waarde:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Waarde"] . '" id="Waarde" name="Waarde" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Landingspagina">Landingspagina:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Landingspagina"] . '" 
                                     id="Landingspagina" name="Landingspagina" readonly>
                         </div>
                         <form action="roldel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="wis" name="wis" 
                                           value="' . $ID . '" title="Deze rol verwijderen.">Rol verwijderen
                                   </button>
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <button class="action-button"><a href="admin.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';
?>