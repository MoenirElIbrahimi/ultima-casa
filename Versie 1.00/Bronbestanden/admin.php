<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     $sql = "   SELECT ID, 
                       Naam, 
                       Email, 
                       Telefoon
                  FROM relaties
                 WHERE ID = " . $relatieid;
     
     $gegevens = $db->query($sql)->fetch();
     
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Admin</title>
               <meta charset="utf-8">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
               <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
               <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
          </head>
          <body>
               <div class="container">
                    <table id="mijngegevens">
                         <tr>
                              <td><h3>Ultima Casa Admin</h3></td>
                              <td class="text-right">Administrator</td>
                              <td>' . $gegevens["Naam"] . '<br>' . $gegevens["Email"] . '<br>' . $gegevens["Telefoon"] . '</td>
                              <td>
                                   <button class="action-button">
                                        <a href="index.html">Uitloggen</a>
                                   </button>
                              </td>
                         </tr>
                    </table>
                    <ul class="nav nav-tabs">
                         <li><a data-toggle="tab" href="#statussen">Statussen</a></li>
                         <li><a data-toggle="tab" href="#rollen">Rollen</a></li>
                         <li><a data-toggle="tab" href="#relaties">Accounts</a></li>
                    </ul>
                    <div class="tab-content">';
                         
     $sql = "   SELECT ID, StatusCode, Status
                  FROM statussen
              ORDER BY StatusCode";

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="statussen" class="tab-pane fade in active">
                              <h3>Statussen</h3>
                              <table id="table_statussen">
                                   <tr>
                                        <th>Status</th>
                                        <th>StatusCode</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th class="button-column">
                                             <form action="statusplus.php">                             
                                                  <button type="submit" class="action-button"
                                                          title="Een nieuwe status toevoegen.">&nbsp;+&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </th>
                                   </tr>';
     foreach ($records as $record) 
     {    $ID = $record['ID'];
          $sql = "SELECT StartDatum, 
                         CONCAT(Straat, ', ', LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), '&nbsp;&nbsp;', Plaats) as Adres
                    FROM biedingen
               LEFT JOIN huizen ON huizen.ID = biedingen.FKhuizenID 
                   WHERE biedingen.FKstatussenID = $ID
                GROUP BY biedingen.FKhuizenID
                ORDER BY StartDatum";      
           
          $statussen = $db->query($sql)->fetchAll();    
          $disabled = "";
          $niet = "Deze status verwijderen.";
          if ($statussen)
          {    $disabled = " disabled";
               $niet = "Deze status mag NIET verwijderd worden.";
          }
          echo                    '<tr>
                                        <td>' . $record['Status'] . '</td>
                                        <td>' . $record['StatusCode'] . '</td>
                                        <td class="button-column">
                                             <form action="statusedit.php">                             
                                                  <button type="submit" class="action-button" id="edit" name="edit" 
                                                          value="' . $record['ID'] . '" title="Deze status wijzigen.">...
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                             <form action="statusmin.php">                             
                                                  <button type="submit" class="action-button" id="wis" name="wis"' . $disabled . ' 
                                                          value="' . $record['ID'] . '" title="' . $niet . '">&nbsp;-&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                            <button type="button" class="action-button" title="Huizen met deze status." 
                                                    data-toggle="collapse" data-target="#huizen_' . $record['ID'] . '">&nbsp;&#9660;&nbsp;
                                            </button>
                                       </td>
                                   </tr>
                                   <tr>
                                        <td colspan=5 >
                                             <div id="huizen_' . $record['ID'] . '" class="collapse">
                                                  <table id="table_huizen" class="details">
                                                       <tr>';
          if (!$statussen)
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Er zijn geen huizen met status ' . $record["StatusCode"] . ' - ' . $record["Status"] . '</h4>
                                                           </th>';
          }
          else
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Huizen met status ' . $record["StatusCode"] . ' - ' . $record["Status"] . '</h4>
                                                           </th>
                                                       </tr>
                                                       <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Adres</th>
                                                            <th>Te koop sinds</th>
                                                            <th>&nbsp;</th>
                                                       </tr>';
               foreach ($statussen as $record) 
               {    echo                              '<tr>
                                                            <td>&nbsp;</td>                                             
                                                            <td>' . $record['Adres'] . '</td>                                             
                                                            <td>' . $record['StartDatum'] . '</td>
                                                            <td>&nbsp;</td>                                             
                                                       </tr>';
               }
          };
          echo                                   '</table>
                                             
                                             </div>
                                        </td>
                                   </tr>';    
     }
     echo                    '</table>
                         </div>';

     $sql = "   SELECT ID, Naam, Omschrijving, Waarde, Landingspagina
                  FROM rollen
              ORDER BY Waarde";

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="rollen" class="tab-pane fade">
                              <h3>Rollen</h3>
                              <table id="table_rollen">
                                   <tr>
                                        <th>Rol</th>
                                        <th>Omschrijving</th>
                                        <th>Waarde</th>
                                        <th>Landingspagina</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th class="button-column">
                                             <form action="rolplus.php">                             
                                                  <button type="submit" class="action-button" id="plus" name="plus" 
                                                          title="Een nieuwe rol toevoegen.">&nbsp;+&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </th>
                                   </tr>';
     foreach ($records as $record) 
     {    $ID = $record['ID'];
          $sql = "SELECT Naam, Email, Telefoon
                    FROM relaties
                   WHERE relaties.FKrollenID = $ID
                ORDER BY relaties.Naam";
          
          $relaties = $db->query($sql)->fetchAll();  
          
          $disabled = "";
          $niet = "Deze rol verwijderen.";
          if ($relaties)
          {    $disabled = " disabled";
               $niet = "Deze rol mag NIET verwijderd worden.";
          }
          echo                    '<tr>
                                        <td>' . $record['Naam'] . '</td>
                                        <td>' . $record['Omschrijving'] . '</td>
                                        <td>' . $record['Waarde'] . '</td>
                                        <td>' . $record['Landingspagina'] . '</td>
                                        <td class="button-column">
                                             <form action="roledit.php">                             
                                                  <button type="submit" class="action-button" id="edit" name="edit" 
                                                          value="' . $record['ID'] . '" title="Deze rol wijzigen.">...
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                             <form action="rolmin.php">                             
                                                  <button type="submit" class="action-button" id="wis" name="wis"' . $disabled . ' 
                                                          value="' . $record['ID'] . '" title="' . $niet . '">&nbsp;-&nbsp;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td class="button-column">
                                            <button type="button" class="action-button" title="Relaties met deze rol." 
                                                    data-toggle="collapse" data-target="#relaties_' . $record['ID'] . '">&nbsp;&#9660;&nbsp;
                                            </button>
                                       </td>
                                   </tr>
                                   <tr>
                                        <td colspan=5 >
                                             <div id="relaties_' . $record['ID'] . '" class="collapse">
                                                  <table id="table_relaties" class="details">
                                                       <tr>';
          if (!$relaties)
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Er zijn geen relaties met rol ' . $record["Naam"] . ' - ' . $record["Omschrijving"] . '</h4>
                                                           </th>';
          }
          else
          {    echo                                        '<th colspan=4 class="cell-center">
                                                                 <h4>Relaties met rol ' . $record["Naam"] . ' - ' . $record["Omschrijving"] . '</h4>
                                                           </th>
                                                       </tr>
                                                       <tr>
                                                            <th>&nbsp;</th>
                                                            <th>Naam</th>
                                                            <th>Email</th>
                                                            <th>Telefoon</th>
                                                            <th>&nbsp;</th>
                                                       </tr>';
               foreach ($relaties as $record) 
               {    echo                              '<tr>
                                                            <td>&nbsp;</td>                                             
                                                            <td>' . $record['Naam'] . '</td>                                             
                                                            <td>' . $record['Email'] . '</td>
                                                            <td>' . $record['Telefoon'] . '</td>
                                                            <td>&nbsp;</td>                                             
                                                       </tr>';
               }
          };
          echo                                   '</table>
                                             
                                             </div>
                                        </td>
                                   </tr>';
     }
     
     echo                    '</table>
                         </div>';
                         
     $sql = "   SELECT relaties.Naam AS Naam, Email, Telefoon, Omschrijving,
                       relaties.ID AS RID
                  FROM relaties
             LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
              ORDER BY rollen.Waarde DESC, Naam";

     $records = $db->query($sql)->fetchAll();    
                         
     echo               '<div id="relaties" class="tab-pane fade">
                              <h3>Accounts</h3>
                              <table id="table_relaties">
                                   <tr>
                                        <th>Naam</th>
                                        <th>Email</th>
                                        <th>Telefoon</th>
                                        <th>Rol</th>
                                        <th>&nbsp;</th>
                                   </tr>';
     foreach ($records as $record) 
     {    echo                    '<tr>
                                        <td>' . $record['Naam'] . '</td>
                                        <td>' . $record['Email'] . '</td>
                                        <td>' . $record['Telefoon'] . '</td>                                             
                                        <td>' . $record['Omschrijving'] . '</td>                                             
                                        <td>
                                             <form action="relatieedit.php">  
                                                  <button type="submit" class="action-button" id="rel" name="rel" 
                                                          value="' . $record['RID'] . '" title="De rol van dit account wijzigen.">&#x263A;
                                                  </button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
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