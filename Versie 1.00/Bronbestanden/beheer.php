<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     
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
               <div class="container">' .
                    InlogKop($relatieid, "Ultima Casa beheer") .
                   '<ul class="nav nav-tabs">
                         <li><a data-toggle="tab" href="#archief">Huizen</a></li>
                         <li><a data-toggle="tab" href="#relaties">Relaties</a></li>
                         <li><a data-toggle="tab" href="#adressen">Adressen</a></li>
                    </ul>
                    <div class="tab-content">';
                         
     $sql = "  SELECT CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) AS Adres, 
                      StartDatum, StatusDatum, Status, huizen.ID as HID
                 FROM biedingen
            LEFT JOIN huizen ON huizen.ID = FKhuizenID
            LEFT JOIN statussen ON statussen.ID = FKstatussenID
                WHERE StatusCode > 100
             ORDER BY Datum, Postcode";

     $archief = $db->query($sql)->fetchAll();  

     echo               '<div id="archief" class="tab-pane fade in active">
                              <h3>Huizen van de markt halen</h3>
                              <form action="archiefmin.php">  
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <table id="table_archief">
                                        <tr>
                                             <th>Datum status</th>
                                             <th>Status</th>
                                             <th>Adres</th>
                                             <th>Te koop sinds</th>
                                             <th>&nbsp;</th>
                                        </tr>';
     foreach ($archief as $bod) 
     {    $biedingen = $db->query($sql)->fetchAll();
          echo                         '<tr>
                                             <td>' . $bod['StatusDatum'] . '</td>
                                             <td>' . $bod['Status'] . '</td>
                                             <td>' . $bod['Adres'] . '</td>                                             
                                             <td>' . $bod['StartDatum'] . '</td>                                             
                                             <td>
                                                  <button type="submit" class="action-button" id="huis" name="huis" 
                                                          value="' . $bod['HID'] . '" title="Dit huis van de markt halen.">&nbsp;-&nbsp;
                                                  </button>                                        
                                             </td>
                                        </tr>';
     }
     
     echo                         '</table>
                              </form>
                         </div>';
     
     $sql = "   SELECT relaties.Naam AS Naam, Email, Telefoon,
                       relaties.ID AS RID, DATE_FORMAT(relaties.Gewijzigd, '%Y-%m-%d') AS Gewijzigd
                  FROM relaties
             LEFT JOIN huizen ON huizen.FKrelatiesID = relaties.ID 
             LEFT JOIN biedingen ON biedingen.FKrelatiesID = relaties.ID 
             LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
                 WHERE (ISNULL(huizen.ID)) AND (ISNULL(biedingen.ID)) AND (rollen.Waarde < 20)              
              ORDER BY Gewijzigd, Naam";

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="relaties" class="tab-pane fade">
                              <h3>Relaties opschonen</h3>
                              <form action="relatiemin.php">  
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <table id="table_relaties">
                                        <tr>
                                             <th>Naam</th>
                                             <th>Email</th>
                                             <th>Telefoon</th>
                                             <th>Laatste wijziging</th>
                                             <th>&nbsp;</th>
                                        </tr>';
     foreach ($records as $record) 
     {    echo                         '<tr>
                                             <td>' . $record['Naam'] . '</td>
                                             <td>' . $record['Email'] . '</td>
                                             <td>' . $record['Telefoon'] . '</td>                                             
                                             <td>' . $record['Gewijzigd'] . '</td>                                             
                                             <td>
                                                  <button type="submit" class="action-button" id="ID" name="ID" 
                                                          value="' . $record['RID'] . '" title="Deze relatie verwijderen.">&nbsp;-&nbsp;
                                                  </button>';
     echo                                   '</td>
                                        </tr>';
     }
     
     echo                         '</table>
                              </form>
                         </div>';

     $sql = "   SELECT ID, Straat, CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2)) AS Postcode, Plaats,
                       DATE_FORMAT(Gewijzigd, '%Y-%m-%d') AS Gewijzigd
                  FROM huizen
                 WHERE ID NOT IN (Select FKhuizenID FROM biedingen)  
              ORDER BY Gewijzigd, Postcode";

     $records = $db->query($sql)->fetchAll();
     
     echo               '<div id="adressen" class="tab-pane fade">
                              <h3>Huizen zonder biedingen</h3>
                              <form action="adresmin.php">  
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <table id="table_adressen">
                                        <tr>
                                             <th>Straat</th>
                                             <th>Postcode</th>
                                             <th>Plaats</th>
                                             <th>Laatste wijziging</th>
                                             <th>&nbsp;</th>
                                        </tr>';
     foreach ($records as $record) 
     {    echo                         '<tr>
                                             <td>' . $record['Straat'] . '</td>
                                             <td>' . $record['Postcode'] . '</td>
                                             <td>' . $record['Plaats'] . '</td>                                             
                                             <td>' . $record['Gewijzigd'] . '</td>                                             
                                             <td>
                                                  <button type="submit" class="action-button" id="ID" name="ID" 
                                                               value="' . $record['ID'] . '" title="Dit adres verwijderen.">&nbsp;-&nbsp;
                                                  </button>
                                             </td>
                                        </tr>';
     }
     
     echo                         '</table>
                              </form>
                         </div>
                    </div>
               </div>
          </body>
     </html>';
?>