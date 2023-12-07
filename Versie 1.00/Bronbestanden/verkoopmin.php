<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $huizenid = $_GET['wis'];
     $sql = "   SELECT huizen.ID AS HID,
                       StartDatum,
                       CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) as Adres,
                       Bod,
                       Datum,
                       Status,
                       huizen.FKrelatiesID as RID
                  FROM huizen
             LEFT JOIN relaties ON relaties.ID = huizen.FKrelatiesID
             LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKStatussenID             
                 WHERE huizen.ID = $huizenid";
     
     $huis = $db->query($sql)->fetch();
     

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
                         <h3>De verkoop van dit huis intrekken</h3>
                              <div class="form-group">
                                   <label for="StartDatum">Te koop sinds:</label>
                                   <input type="text" class="form-control" value="' . $huis["StartDatum"] . '" id="StartDatum" name="StartDatum" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Adres">Adres:</label>
                                   <input type="text" class="form-control" value="' . $huis["Adres"] . '" id="Adres" name="Adres" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Bod">Geboden:</label>
                                   <input type="text" class="form-control" value="&euro; ' . $huis["Bod"] . '" id="Bod" name="Bod" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Datum">Datum:</label>
                                   <input type="text" class="form-control" value="' . $huis["Datum"] . '" id="Datum" name="Datum" readonly>
                              </div>
                              <div class="form-group">
                                   <label for="Status">Status:</label>
                                   <input type="text" class="form-control" value="' . $huis["Status"] . '" id="Status" name="Status" readonly>
                              </div>
                         <form action="verkoopdel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="wis" name="wis" 
                                           value="' . $huizenid . '" title="De verkoop van dit huis intrekken.">Intrekken
                                   </button>
                                   <input type="hidden" value="' . $huis["RID"] . '" id="RID" name="RID">
                                   <input type="hidden" value="' . $huis["HID"] . '" id="AID" name="AID">
                                   <button class="action-button"><a href="relatie.php?RID=' . $huis["RID"] . '" >Annuleren</a></button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';

?>