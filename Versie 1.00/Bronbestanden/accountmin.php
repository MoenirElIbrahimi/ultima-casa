<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["ID"]; 

     $sql = "   SELECT ID, 
                       Naam, 
                       Email, 
                       Telefoon,
                       Wachtwoord
                  FROM relaties
                 WHERE ID = " . $ID;
     
     $gegevens = $db->query($sql)->fetch();
     
     echo 
    '<!DOCTYPE html>
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
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                         <h3>Mijn account definitief verwijderen</h3>
                         <div class="form-group">
                              <label for="Naam">Naam:</label>
                              <input type="text" class="form-control" 
                                     id="Naam" name="Naam"
                                     value="' . $gegevens["Naam"] . '" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Email">E-mail adres:</label>
                              <input type="text" class="form-control" 
                                     id="Email" name="Email"
                                     value="' . $gegevens["Email"] . '" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Telefoon">Telefoon:</label>
                              <input type="tel" class="form-control" id="Telefoon" name="Telefoon" 
                                     value="' . $gegevens["Telefoon"] . '" readonly>
                         </div>
                         <form action="accountdel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="del" name="del" 
                                           value="' . $ID . '">Mijn account definitief verwijderen
                                   </button>
                                   <button class="action-button"><a href="relatie.php?RID=' . $ID . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';
?>