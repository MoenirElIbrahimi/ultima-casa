<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $huisid = $_GET["huis"];
     $beheerderid = $_GET["RID"];
     
     $sql = "SELECT CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) AS Adres, 
                      StartDatum, StatusDatum, Status, huizen.ID as HID
                 FROM biedingen
            LEFT JOIN huizen ON huizen.ID = FKhuizenID
            LEFT JOIN statussen ON statussen.ID = FKstatussenID
                WHERE huizen.ID = $huisid";
     
     $gegevens = $db->query($sql)->fetch();
     
     $sql = "  SELECT CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) AS Adres, 
                      StartDatum, StatusDatum, Status, biedingen.ID AS BID, huizen.ID as HID
                 FROM biedingen
            LEFT JOIN huizen ON huizen.ID = FKhuizenID
            LEFT JOIN statussen ON statussen.ID = FKstatussenID
                WHERE huizen.ID = $huisid";
     
     $biedingen = $db->query($sql)->fetchAll();

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
                    <div class="col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3" id="details">
                         <h3>Huis van de markt halen</h3>
                         <h4>Geplaatste biedingen op</h4>
                         <h4>' . $biedingen[0]["Adres"] . '</h4>
                         <table id="table_archief" class="details">
                              <tr>
                                   <th>&nbsp;</th>
                                   <th>Datum status</th>
                                   <th>Status</th>
                                   <th>Te koop sinds</th>
                                   <th>&nbsp;</th>
                              </tr>';
     foreach ($biedingen as $bod) 
     {    
          echo               '<tr>
                                   <td>&nbsp;</td>
                                   <td>' . $bod['StatusDatum'] . '</td>
                                   <td>' . $bod['Status'] . '</td>
                                   <td>' . $bod['StartDatum'] . '</td>                                             
                                   <td>&nbsp;</td>
                              </tr>';
     }
     
     echo               '</table><br><br>
                         <form action="archiefdel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="wis" name="wis" 
                                           value="' . $huisid . '" title="Dit huis van de markt halen.">Huis van de markt halen
                                   </button>
                                   <input type="hidden" value="' . $beheerderid . '" id="RID" name="RID">
                                   <button class="action-button"><a href="beheer.php?RID=' . $beheerderid . '" >Annuleren</a></button>
                              </div>
                         </form>
               </div>
               </div>
          </body>
     </html>';
?>