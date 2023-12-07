<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["ID"];
     $relatieid = $_GET["RID"];
     
     $sql = "SELECT Naam, Email, Telefoon, DATE_FORMAT(Gewijzigd, '%Y-%m-%d') AS Gewijzigd
               FROM relaties
              WHERE relaties.ID = " . $ID;
     
     $gegevens = $db->query($sql)->fetch();
     
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Beheer</title>
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
                         <h3>Relatie verwijderen</h3>
                         <div class="form-group">
                              <label for="Naam">Naam:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Naam"] . '" id="Naam" name="Naam" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Telefoon">Telefoon:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Telefoon"] . '" id="Telefoon" name="Telefoon" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Email">Email:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Email"] . '" id="Email" name="Email" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Gewijzigd">Datum gewijzigd:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Gewijzigd"] . '" id="Gewijzigd" name="Straat" Gewijzigd>
                         </div>
                         <form action="relatiedel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="wis" name="wis" 
                                           value="' . $ID . '" title="Deze relatie verwijderen.">Relatie verwijderen
                                   </button>
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <button class="action-button"><a href="beheer.php?RID=' . $relatieid . '" >Annuleren</a></button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';
?>