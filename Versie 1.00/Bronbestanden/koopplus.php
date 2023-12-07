<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     
     $filter = 0;
     $filterids = "";
     
     if (isset($_GET['filter']))
     {    $filter = 1;
          $sql = "SELECT FKhuizenID AS huizenID
                    FROM mijncriteria 
               LEFT JOIN huiscriteria ON huiscriteria.FKcriteriaID = mijncriteria.FKcriteriaID
               LEFT JOIN criteria ON criteria.ID = mijncriteria.FKcriteriaID
                   WHERE (mijncriteria.FKrelatiesID = $relatieid) 
                GROUP BY huizenID
                  HAVING SUM(IF(criteria.Type < 2, 
                                huiscriteria.Waarde BETWEEN mijncriteria.Van AND mijncriteria.Tem, 
                                mijncriteria.Van = huiscriteria.Waarde)) = COUNT(*)";
          $fids = $db->query($sql)->fetchAll();
          
          $filterids = array(-1);
          foreach ($fids as $filterid) 
          {    $filterids[] = $filterid["huizenID"];
          }
          $filterids = "(huizen.ID IN (" . implode(",", $filterids) . ")) AND ";
     }; 

     $sql = "   SELECT huizen.ID AS HID,
                       StartDatum,
                       Straat,
                       CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats
                  FROM huizen 
             LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
                 WHERE $filterids (IFNULL(StatusCode, 0) < 10) AND (huizen.ID NOT IN (SELECT FKhuizenID FROM biedingen WHERE FKrelatiesID = 673))
              GROUP BY huizen.ID"; 

     $kopen = $db->query($sql)->fetchAll();
     
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
                    <form action="koopins.php">   
                         <table id="mijnkopen" class="koop">
                              <tr>
                                   <th colspan=3>
                                        <h4>';
     if ($filter > 0)
     {    echo                              'Geselecteerde';
     }
     else 
     {    echo                              'Alle';
     };
     echo                                   ' beschikbare huizen
                                        </h4>
                                   </th>
                                   <th class="button-column">
                                        <button class="action-button" disabled>';
     if ($filter > 0)
     {    echo                              '<a href="koopplus.php?RID=' . $relatieid . '" title="Alle beschikbare huizen tonen.">&#x2610;</a>';
     }
     else
     {    echo                              '<a href="koopplus.php?RID=' . $relatieid . '&filter" title="Alleen geselecteerde huizen tonen.">&#x2611;</a>';
     }
     echo                              '</button>
                                   </th>
                                   <th><button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Annuleren</a></button>
                                   </th>
                              </tr>';
     if (count($kopen) > 0)
     {     echo 
                             '<tr>
                                   <th>Te koop sinds</th>
                                   <th>Straat</th>
                                   <th>Plaats</th>
                                   <th>&nbsp;</th>
                                   <th>&nbsp;</th>
                              </tr>';
          foreach ($kopen as $tekoop) 
          {    $sql = "SELECT IF(TYPE=1, Waarde, IF(Waarde > 0, 'Ja', 'Nee')) AS Waarde, Criterium, Type   
                         FROM huiscriteria
                    LEFT JOIN criteria ON criteria.ID = huiscriteria.FKcriteriaID
                        WHERE huiscriteria.FKhuizenID = " . $tekoop['HID'] . "
                     ORDER BY Volgorde";
                     
               $criteria = $db->query($sql)->fetchAll();  
               
               echo          '<tr>
                                   <td>' . $tekoop['StartDatum'] . '</td>
                                   <td>' . $tekoop['Straat'] . '</td>
                                   <td>' . $tekoop['Plaats'] . '</td>                                             
                                   <td>';
               $disabled = " ";
               $details = "Details.";
               if (count($criteria) < 1)
               {    $disabled = " disabled";
                    $details = "Er zijn geen details beschikbaar.";
               }
               echo                     
                                       '<button type="button" class="action-button"' . $disabled . '
                                               data-toggle="collapse" data-target="#acc_' . $tekoop['HID'] . '" 
                                               title="' . $details . '">&nbsp;&#9660;&nbsp;
                                        </button>';
               echo
                                  '</td>
                                   <td class="button-column">
                                        <button type="submit" class="action-button" id="plus" name="plus" 
                                                value="' . $tekoop['HID'] . '" title="Dit huis toevoegen aan mijn lijst.">+</button>
                                   </td>
                              </tr>
                              <tr>
                                   <td colspan=5>
                                        <div id="acc_' . $tekoop['HID'] . '" class="collapse">
                                             <div class="form-inline">';
          foreach ($criteria as $criterium)
          {    echo                              '<div class="form-group spacer-right">' . 
                                                       $criterium["Criterium"] . ': <label>' . $criterium["Waarde"] .  '</label>
                                                  </div>';
                                             
          }
          echo                              '</div>
                                        </div>
                                   </td>
                              </tr>';
          }
     }
     else
{    echo                    '<tr><td colspan=5>
                                        En staan geen huizen te koop die voldoen aan je zoekcriteria          
                                   </td>
                              </tr>';
     }
echo                    '</table>
                         <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                    </form>
               </div>
          </body>
     </html>';

?>