<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $biedingenid = $_GET['wis'];
     $sql = "   SELECT huizen.ID AS HID,
                       StartDatum,
                       CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Adres,
                       Bod,
                       Datum,
                       Status,
                       biedingen.FKrelatiesID as RID
                  FROM biedingen
             LEFT JOIN relaties ON relaties.ID = biedingen.FKrelatiesID
             LEFT JOIN huizen ON huizen.ID = biedingen.FKhuizenID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKStatussenID             
                 WHERE biedingen.ID = $biedingenid";
     
     $bieding = $db->query($sql)->fetch();
     

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
                         <h3>Huis verwijderen uit mijn lijst</h3>
                              <div class="form-group">
                                   <label for="StartDatum">Te koop sinds:</label>
                                   <input type="text" class="form-control" value="' . $bieding["StartDatum"] . '" id="StartDatum" name="StartDatum" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Adres">Adres:</label>
                                   <input type="text" class="form-control" value="' . $bieding["Adres"] . '" id="Adres" name="Adres" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Bod">Geboden:</label>
                                   <input type="text" class="form-control" value="&euro; ' . $bieding["Bod"] . '" id="Bod" name="Bod" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Datum">Datum:</label>
                                   <input type="text" class="form-control" value="' . $bieding["Datum"] . '" id="Datum" name="Datum" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Status">Status:</label>
                                   <input type="text" class="form-control" value="' . $bieding["Status"] . '" id="Status" name="Status" readonly>
                              </div>
                         <form action="koopdel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="wis" name="wis" 
                                           value="' . $biedingenid . '" title="Dit huis verwijderen uit mijn lijst.">Verwijderen
                                   </button>
                                   <input type="hidden" value="' . $bieding["RID"] . '" id="RID" name="RID">
                                   <button class="action-button"><a href="relatie.php?RID=' . $bieding["RID"] . '" >Annuleren</a></button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';

?>