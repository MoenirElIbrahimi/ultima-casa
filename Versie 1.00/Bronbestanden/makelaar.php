<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     $sql = "   SELECT ID, 
                       Naam, 
                       Email, 
                       Telefoon,
                       Wachtwoord
                  FROM relaties
                 WHERE ID = " . $relatieid;
     
     $gegevens = $db->query($sql)->fetch();
     
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Makelaar</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">' .
                    InlogKop($relatieid, "Ultima Casa Makelaar");
               
     $sql = "   SELECT StartDatum, Naam, 
                       relaties.ID AS RID,
                       CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) as Adres, 
                       huizen.ID as HID,
                       CONCAT('&euro;&nbsp;', Max(Bod)) AS HoogsteBod
                  FROM huizen
             LEFT JOIN relaties ON relaties.ID = huizen.FKrelatiesID
             LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
             WHERE StatusCode < 100
             GROUP BY huizen.ID
              ORDER BY Postcode, StartDatum";

     $records = $db->query($sql)->fetchAll();   
     
     $sql = "  SELECT *
                 FROM statussen
             ORDER BY StatusCode";

     $statussen = $db->query($sql)->fetchAll();  
     
     echo          '<h3>Te koop aangeboden</h3>
                    <table id="table_huizen">
                         <tr>
                              <th>Te koop sinds</th>
                              <th>Adres</th>
                              <th>Verkoper</th>
                              <th>Hoogste bod</th>
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                         </tr>';
     foreach ($records as $record) 
     {    $huisid = $record['HID'];
          $sql = "SELECT Naam, CONCAT('&euro;&nbsp;', Bod) AS Bod, 
                         DATE_FORMAT(Datum, '%d-%m-%Y') AS Datum, 
                         biedingen.ID AS BID, 
                         relaties.ID AS RID,
                         Status, biedingen.FKstatussenID AS SID
                    FROM biedingen
               LEFT JOIN relaties ON relaties.ID = biedingen.FKrelatiesID
               LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
                   WHERE biedingen.FKhuizenID = $huisid
              ORDER BY Bod DESC, Datum DESC";
          $biedingen = $db->query($sql)->fetchAll();
          
          $sql = "SELECT IF(TYPE=1, Waarde, IF(Waarde > 0, 'Ja', 'Nee')) AS Waarde, Criterium, Type   
                    FROM huiscriteria
               LEFT JOIN criteria ON criteria.ID = huiscriteria.FKcriteriaID
                   WHERE huiscriteria.FKhuizenID = $huisid
              ORDER BY Volgorde";
          $criteria = $db->query($sql)->fetchAll();  
          
          echo          '<tr>
                              <td>' . $record['StartDatum'] . '</td>
                              <td>' . $record['Adres'] . '</td>                                             
                              <td>' . $record['Naam'] . '</td>                                             
                              <td>' . $record['HoogsteBod'] . '</td>
                              <td>
                                   <button type="button" class="action-button" 
                                           data-toggle="collapse" data-target="#acc_' . $record['HID'] . '">&nbsp;&#9660;&nbsp;
                                   </button>
                              </td>
                              <td>
                                   <button class="action-button" title="Deze verkoper een e-mail sturen."> 
                                        <a href="maakmail.php?RID=' . $relatieid . '&FID=' . $relatieid . '&TID=' . $record['RID'] . '">&#x2709;
                                   </button>
                              </td>
                         </tr>
                         <tr>
                              <td colspan=5>
                                   <div id="acc_' . $record['HID'] . '" class="collapse">
                                        <table class="details">
                                             <tr>
                                                  <th class="cell-center" width="60%">Biedingen</th>
                                                  <th class="cell-center">Criteria</th>
                                             </tr>
                                             <tr>
                                                  <td>
                                                       <table class="kopers">
                                                            <tr>
                                                                 <th>Naam</th>
                                                                 <th>Bod</th>
                                                                 <th>Datum</th>
                                                                 <th>Status</th>
                                                                 <th>&nbsp;</th>
                                                            </tr>';
          if (count($biedingen) > 0)
          {    foreach ($biedingen as $bod)
               {    echo                                   '<tr>
                                                                 <td>' . $bod["Naam"] . '</td> 
                                                                 <td>' . $bod["Bod"] .  '</td>
                                                                 <td>' . $bod["Datum"] . '</td>
                                                                 <td>
                                                                       <form action="bodstatusupd.php" method="GET">
                                                                           <div class="form-group form-inline">
                                                                                <select class="form-control small" id="SID" name="SID">';
                    foreach ($statussen as $status) 
                    {    $selected = "";
                         if ($status["ID"] == $bod["SID"])
                         {    $selected = " selected";
                         }
                         echo                                                       '<option value="' . $status['ID'] . '"' . $selected . '>' . $status['Status'] .  
                                                                                    '</option>';
                    };
                    echo                                                       '</select>
                                                                                <button type="submit" class="action-button spacer-left" id="BID" name="BID" 
                                                                                        value="' . $bod["BID"] . '" title="De status aanpassen.">&#10003;
                                                                                </button>
                                                                           </div>
                                                                           <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                                                      </form>
                                                                 </td>
                                                                 <td>
                                                                      <button class="action-button" title="Deze koper een e-mail sturen."> 
                                                                           <a href="maakmail.php?RID=' . $relatieid . 
                                                                                                '&FID=' . $relatieid . 
                                                                                                '&TID=' . $bod['RID'] . '">&#x2709;
                                                                      </button>
                                                                 </td>
                                                            </tr>';
               }
          }
          else
          {    echo                                        '<tr>
                                                                 <td>Er is nog niet geboden op dit huis</td>
                                                            </tr>';
          }
          echo                                        '</table>
                                                       
                                                  </td>                                                            
                                                  <td>
                                                       <table class="kopers accent">';
          $split = 10;
          foreach ($criteria as $criterium)
          {    if ($split > 1)
               {    echo                                   '<tr>';
                    $split = 0;
               }
               echo                                             '<td>' . $criterium["Criterium"] . '</td>
                                                                 <td>' . $criterium["Waarde"] .  '</td>';
               $split++;
               if ($split > 1)
               {    echo                                   '</tr>';
               }
          }                                        
          echo                                                  '
                                                       </table>
                                                  </td>
                                             </tr>
                                        </table>
                                   </div>
                              </td>
                         </tr>';
     }
     
     echo          '</table>
               </div>
          </body>
     </html>';
?>