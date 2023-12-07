<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $biedingenid = $_GET['bieden'];
     $sql = "   SELECT huizen.ID AS HID,
                       StartDatum,
                       CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Adres,
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
                         <h3>Een bod op dit huis uitbrengen</h3>
                         <div class="form-group">
                              <label for="StartDatum">Te koop sinds:</label>
                              <input type="text" class="form-control" value="' . $bieding["StartDatum"] . '" id="StartDatum" name="StartDatum" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Adres">Adres:</label>
                              <input type="text" class="form-control" value="' . $bieding["Adres"] . '" id="Adres" name="Adres" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Status">Status:</label>
                              <input type="text" class="form-control" value="' . $bieding["Status"] . '" id="Status" name="Status" readonly>
                         </div>
                         <form action="koopupd.php" method="GET">
                              <div class="form-group button-column accent">
                                   <label for="Bod">Mijn bod voor dit huis is:</label>
                                   <input type="number" class="form-control" 
                                          value="'. $bieding["Bod"] . '" min=0 max=50000000 step=1000
                                          id="Bod" name="Bod" required>
                              </div>
                              <div class="form-group">
                                   <label for="Datum">Datum:</label>
                                   <input type="text" class="form-control" value="' . FormatDatum() . '" id="Datum" name="Datum" readonly>
                              </div>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="BID" name="BID" 
                                           value="' . $biedingenid . '" title="Het bod op dit huis opslaan.">Opslaan
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