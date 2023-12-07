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
               <title>Ultima Casa Secretariaat</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">' .
                    InlogKop($relatieid, "Ultima Casa Secretariaat");
                         
     $sql = "   SELECT relaties.Naam AS Naam, Email, Telefoon, 
                       relaties.ID AS RID
                  FROM relaties
             LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
                 WHERE rollen.waarde < 10
              ORDER BY Naam";

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="relaties" class="tab-pane fade in active">
                              <h3>Relaties</h3>
                              <table id="table_relaties">
                                   <tr>
                                        <th>Naam</th>
                                        <th>Email</th>
                                        <th>Telefoon</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                   </tr>';
     foreach ($records as $record) 
     {    $id = $record['RID'];
          $sql = "SELECT CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) as Adres, 
                         Status
                    FROM biedingen
               LEFT JOIN huizen ON huizen.ID = biedingen.FKhuizenID 
               LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID 
                   WHERE biedingen.FKrelatiesID = $id";
          $biedingen = $db->query($sql)->fetchAll();
          
          $sql = "   SELECT StartDatum, 
                            CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) as Adres
                       FROM huizen
                      WHERE huizen.FKrelatiesID = $id";
     
          $huizen = $db->query($sql)->fetchAll(); 
          
          echo                    '<tr>
                                        <td>' . $record['Naam'] . '</td>
                                        <td>' . $record['Email'] . '</td>
                                        <td>' . $record['Telefoon'] . '</td>                                             
                                        <td>
                                             <button class="action-button" title="Deze relstie een e-mail sturen."> 
                                                  <a href="maakmail.php?RID=' . $relatieid . '&FID=' . $relatieid . '&TID=' . $record['RID'] . '">&#x2709;
                                             </button>
                                        </td>
                                        <td>
                                            <button type="button" class="action-button" 
                                                    data-toggle="collapse" data-target="#acc_' . $record['RID'] . '">&nbsp;&#9660;&nbsp;
                                            </button>
                                       </td>
                                   </tr>
                                   <tr>
                                        <td colspan=4>
                                             <div id="acc_' . $record['RID'] . '" class="collapse">
                                                  <table class="details">
                                                       <tr>
                                                            <th width="50%">Als koper</th>
                                                            <th>Als verkoper</th>
                                                       </tr>
                                                       <tr>
                                                            <td>
                                                                 <table class="details">
                                                                      <tr>
                                                                           <th>&nbsp;</th>
                                                                           <th>Adres</th>
                                                                           <th>Status</th>
                                                                           <th>&nbsp;</th>
                                                                      </tr>';
          if (count($biedingen) > 0)
          {    foreach ($biedingen as $bod)
               {    echo                                             '<tr>
                                                                           <td>&nbsp;</td>
                                                                           <td>' . $bod["Adres"] .  '</td>
                                                                           <td>' . $bod["Status"] . '</td>
                                                                           <td>&nbsp;</td>
                                                                      </tr>';
               }
          }
          else
          {    echo                                                  '<tr>
                                                                           <td>&nbsp;</td>
                                                                           <td>Deze relatie heeft nog geen interesse in een huis</td>
                                                                           <td>&nbsp;</td>
                                                                      </tr>';
          }
          echo                                                  '</table>
                                                            </td>                                                            
                                                            <td>
                                                                 <table class="details">';
          if (count($huizen) > 0)
          {    foreach ($huizen as $huis)
               {    echo                                             '<tr>
                                                                           <th>&nbsp;</th>
                                                                           <th>Te koop sinds</th>
                                                                           <th>Adres</th>
                                                                           <th>&nbsp;</th>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>&nbsp;</td>
                                                                           <td>' . $huis["StartDatum"] . '</td>
                                                                           <td>' . $huis["Adres"] .  '</td>
                                                                           <td>&nbsp;</td>
                                                                      </tr>';
               }
          }
          else
          {    echo                                                  '<tr>
                                                                           <td>&nbsp;</td>
                                                                           <td>Deze relatie heeft (nog) geen huizen te koop staan</td>
                                                                           <td>&nbsp;</td>
                                                                      </tr>';
          }
          echo                                                  '</table>
                                                            </td>
                                                       </tr>
                                                  </table>
                                             </div>
                                        </td>
                                   </tr>';
     }
     
     echo                    '</table>
                         </div>
                    </div>
               </div>
          </body>
     </html>';
?>