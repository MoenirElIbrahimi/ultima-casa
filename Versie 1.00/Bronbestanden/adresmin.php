<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["ID"]; 
     $relatieid = $_GET['RID'];
     
     $sql = "   SELECT Straat, CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2)) AS Postcode, Plaats, 
                       DATE_FORMAT(Gewijzigd, '%Y-%m-%d') AS Gewijzigd
                  FROM huizen
                 WHERE ID = " . $ID;
     
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
                    <div class="tab-content">
                         <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4" id="details">
                              <h3>Adres verwijderen</h3>
                              <div class="form-group">
                                   <label for="Straat">Straat:</label>
                                   <input type="text" class="form-control" value="' . $gegevens["Straat"] . '" id="Straat" name="Straat" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Postcode">Postcode:</label>
                                   <input type="text" class="form-control" value="' . $gegevens["Postcode"] . '" id="Postcode" name="Postcode" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Plaats">Plaats:</label>
                                   <input type="text" class="form-control" value="' . $gegevens["Plaats"] . '" id="Plaats" name="Plaats" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Gewijzigd">Datum gewijzigd:</label>
                                   <input type="text" class="form-control" value="' . $gegevens["Gewijzigd"] . '" id="Gewijzigd" name="Straat" Gewijzigd>
                              </div>
                              <form action="adresdel.php" method="GET">
                                   <div class="form-group">
                                        <button type="submit" class="action-button" id="wis" name="wis" 
                                                value="' . $ID . '" title="Dit adres verwijderen.">Adres verwijderen
                                        </button>
                                        <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                        <button class="action-button"><a href="beheer.php?RID=' . $relatieid . '" >Annuleren</a>
                                        </button>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </body>
     </html>';
?>