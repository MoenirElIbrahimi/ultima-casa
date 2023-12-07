<?php
     include_once("functions.php");
     
     $relatieid = $_GET['RID'];
     
     $filtered = 0;
     $filter = "relaties.ID = " . $relatieid . " AND (StatusCode < 100)";
     $datum = "";
     $bod = "";
     $zoek = "";
     if (isset($_GET['Datum']) && !empty($_GET['Datum']))
     {    $datum = $_GET['Datum'];
          $filtered = 1;
     };
     if (isset($_GET['Bod']) && !empty($_GET['Bod']))
     {    $bod = $_GET['Bod'];
          $filtered = 1;
     };
     if (isset($_GET['Zoek']) && !empty($_GET['Zoek']))
     {    $zoek = $_GET['Zoek'];
          $filtered = 1;
     };
     
     if (!empty($datum))
     {    $filter .= " AND StartDatum > '" . $datum . "'";
     };
     
     if (!empty($bod))
     {    $filter .= " AND Bod > " . $bod;
     };
     
     if (!empty($zoek))
     {    $filter .= " AND CONCAT_WS('', StartDatum, Datum, Bod, Status, Straat, Postcode, Plaats) LIKE '%" . $zoek . "%'";
     };
     
     $db = ConnectDB();
     
     $sql = "   SELECT biedingen.ID as TKID,
                       StartDatum,
                       IF(Bod, Datum, '&nbsp;') AS Datum,
                       CONCAT('&euro; ', Bod) AS Bod,
                       Straat,
                       CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats,
                       Status, 
                       biedingen.FKhuizenID AS HID,
                       huizen.FKRelatiesID as RID
                  FROM biedingen
             LEFT JOIN relaties ON relaties.ID = biedingen.FKRelatiesID 
             LEFT JOIN huizen on huizen.ID = biedingen.FKhuizenID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
                 WHERE " . $filter . "
             ORDER BY Datum";
             
     $kopen = $db->query($sql)->fetchAll();
     
     $sql = "   SELECT huizen.ID as HID,
                       StartDatum,
                       Straat,
                       CONCAT(LEFT(Postcode, 4), ' ', RIGHT(Postcode, 2), ', ', Plaats) as Plaats,
                       Status,
                       CONCAT('&euro; ', Max(Bod)) AS HoogsteBod,
                       Status
                  FROM huizen
             LEFT JOIN relaties ON relaties.ID = huizen.FKRelatiesID 
             LEFT JOIN biedingen ON biedingen.FKhuizenID = huizen.ID
             LEFT JOIN statussen ON statussen.ID = biedingen.FKstatussenID
             WHERE relaties.ID = $relatieid
             GROUP BY huizen.ID
             ORDER BY StartDatum";
             
     $verkopen = $db->query($sql)->fetchAll();
     
     $sql = "   SELECT mijncriteria.ID as CID, Criterium, Van, Tem, Type,
                       IF (Type = 1, Concat(Van, ' t/m ', Tem),  IF (Van > 0, 'Ja', 'Nee')) AS Waarde
                  FROM mijncriteria
             LEFT JOIN criteria ON criteria.ID = FKcriteriaID
                 WHERE FKrelatiesID = $relatieid";
     
     $criteria = $db->query($sql)->fetchAll();
     
     $sql = "   SELECT ID, 
                       Naam, 
                       Email, 
                       Telefoon,
                       Wachtwoord
                  FROM relaties
                 WHERE ID = " . $relatieid;
     
     $gegevens = $db->query($sql)->fetch();
     
     $sql = "   SELECT relaties.ID AS MID
                  FROM relaties
             LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
                 WHERE Waarde BETWEEN 30 AND 39 
                 LIMIT 1"; // de eerste makelaar van Ultima Casa
     
     $makelaar = $db->query($sql)->fetch();
     
     echo '
          <!DOCTYPE html>
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
               <div class="container">' .
                    InlogKop($relatieid, "Mijn Ultima Casa", 
                                         '<td>
                                               <button class="action-button" title="De makelaar een e-mail sturen."> 
                                                       <a href="maakmail.php?RID=' . $relatieid . '&FID=' . $relatieid . '&TID=' . $makelaar["MID"] . '">&#x2709;
                                               </button>
                                          </td>') .
                   '<ul class="nav nav-tabs">
                         <li><a data-toggle="tab" href="#kopen">Huizen die ik wil kopen</a></li>
                         <li><a data-toggle="tab" href="#mijncriteria">Zoekcriteria</a></li>
                         <li><a data-toggle="tab" href="#verkopen">Huizen die ik te koop aanbied</a></li>
                         <li><a data-toggle="tab" href="#account">Account</a></li>
                    </ul>
                    
                    <div class="tab-content">
                         <div id="kopen" class="tab-pane fade in active">
                              <h3>Deze huizen wil ik (misschien) kopen</h3>
                              <table id="mijnkopen">
                                   <tr>
                                        <th>Te koop sinds</th>
                                        <th>Straat</th>
                                        <th>Plaats</th>
                                        <th>Bod</th>
                                        <th>Datum bod</th>
                                        <th>Status</th>
                                        <th class="button-column">';
     if ($filtered < 1)
     {    echo                              '<button type="button" class="action-button" title="Lijst filteren"
                                                     data-toggle="collapse" data-target="#filter_tab">&nbsp;&#1198;&nbsp;
                                             </button>';
     }
     else
     {    echo                              '<button class="action-button" title="Filtering opheffen">
                                                  <a href="relatie.php?RID=' . $relatieid . '" >&nbsp;&#1200;&nbsp;</a>
                                             </button>';
     }
     echo                              '</th>
                                        <th class="button-column" colspan=2>
                                             <form action="koopplus.php">                             
                                                  <button type="submit" class="action-button" id="RID" name="RID" 
                                                          value="' . $relatieid . '" title="Een nieuw huis aan mijn lijst toevoegen.">&nbsp;+&nbsp;</button>
                                             </form>
                                        </th>
                                   </tr>
                                   <tr>
                                        <td class="laag" colspan=9>
                                             <div id="filter_tab" class="collapse">
                                                  <form action="">  
                                                       <table class="details">
                                                            <tr>
                                                                 <td width="30%">
                                                                      <div class="form-group">
                                                                           <label for="Datum">Vanaf datum te koop:</label>
                                                                           <input type="date" class="form-control" 
                                                                                  id="Datum" name="Datum">
                                                                      </div>
                                                                 </td>
                                                                 <td width="30%">
                                                                      <div class="form-group">
                                                                           <label for="Bod">Vanaf bod:</label>
                                                                           <input type="number" class="form-control" 
                                                                                  id="Bod" name="Bod" min=0 max=10000000 step=1000>
                                                                      </div>
                                                                 </td>
                                                                 <td width="30%">
                                                                      <div class="form-group">
                                                                           <label for="Status">Zoek alles:</label>
                                                                           <input type="text" class="form-control" name="Zoek" id="Zoek">
                                                                      </div>
                                                                 </td>
                                                                 <td class="button-column">
                                                                      <button type="submit" class="action-button" id="RID" name="RID" 
                                                                              value="' . $relatieid . '" title="Huizen filteren op deze voorwaarden.">Ok
                                                                      </button>
                                                                 </td>
                                                            </tr>
                                                       </table>
                                                  </form>
                                             </div>
                                        </td>
                                   </tr>
';
     foreach ($kopen as $tekoop) 
     {    echo                    '<tr>
                                        <td>' . $tekoop['StartDatum'] . '</td>
                                        <td>' . $tekoop['Straat'] . '</td>
                                        <td>' . $tekoop['Plaats'] . '</td>                                             
                                        <td>' . $tekoop['Bod'] . '</td>                                             
                                        <td>' . $tekoop['Datum'] . '</td>                                             
                                        <td>' . $tekoop['Status'] . '</td>
                                        <td class="button-column">
                                             <form action="koopbod.php">                             
                                                  <button type="submit" class="action-button" id="bieden" name="bieden" 
                                                          value="' . $tekoop['TKID'] . '" title="Een bod op dit huis uitbrengen.">&euro;</button>
                                             </form>
                                        </td>
                                        <td class="button-column">
                                             <button class="action-button" title="Contact opnemen met de verkoper.">
                                                  <a href="maakmail.php?RID=' . $relatieid . '&FID=' . $relatieid . '&TID=' . $tekoop["RID"] . '">&#x2709;
                                                  
                                             </button>
                                        </td>
                                        <td class="button-column">
                                             <form action="koopmin.php">     
                                                  <button type="submit" class="action-button" id="wis" name="wis" 
                                                          value="' . $tekoop['TKID'] . '" title="Dit huis uit mijn lijst verwijderen.">&nbsp;-&nbsp;</button>
                                             </form>
                                        </td>
                                   </tr>';
     }
     echo                    '</table>
                         </div>
                         
                         <div id="verkopen" class="tab-pane fade">
                              <h3>Deze huizen bied ik te koop aan</h3>
                              <table id="mijnkopen" class="verkoop">
                                   <tr>
                                        <th>Te koop sinds</th>
                                        <th>Straat</th>
                                        <th>Plaats</th>
                                        <th>Hoogste bod</th>
                                        <th>Status</th>
                                        <th class="button-column" colspan="2">
                                             <form action="verkoopplus.php">                             
                                                  <button type="submit" class="action-button" id="RID" name="RID" 
                                                          value="' . $relatieid . '" title="Een nieuw huis in de verkoop doen.">&nbsp;+&nbsp;</button>
                                             </form>
                                        </th>
                                   </tr>';
     foreach ($verkopen as $verkoop) 
     {    echo                    '<tr>
                                        <td>' . $verkoop['StartDatum'] . '</td>
                                        <td>' . $verkoop['Straat'] . '</td>
                                        <td>' . $verkoop['Plaats'] . '</td>                                             
                                        <td>' . $verkoop['HoogsteBod'] . '</td>
                                        <td>' . $verkoop['Status'] . '</td>
                                        <td class="button-column">
                                             <form action="verkoopedit.php">     
                                                  <button type="submit" class="action-button" id="HID" name="HID" 
                                                          value="' . $verkoop['HID'] . '" title="Deze verkoop wijzigen.">...</button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">       
                                             </form>
                                        </td>
                                        <td>
                                             <form action="verkoopmin.php">     
                                                  <button type="submit" class="action-button" id="wis" name="wis" 
                                                          value="' . $verkoop['HID'] . '" title="Deze verkoop intrekken.">&nbsp;-&nbsp;</button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>

                                   </tr>';
          }
     echo                    '</table>
                         </div>
                         
                         <div id="mijncriteria" class="tab-pane fade">
                              <h3>Op basis van deze criteria zoek ik een huis</h3>
                              <table id="criteria">
                                   <tr>
                                        <th>Criterium</th>
                                        <th>Waarde</th>
                                        <th class="button-column" colspan="2">
                                             <form action="mijncriteriumplus.php">                             
                                                  <button type="submit" class="action-button" id="RID" name="RID" 
                                                          value="' . $relatieid . '" title="Een nieuw criterium toevoegen.">&nbsp;+&nbsp;</button>
                                             </form>
                                        </th>
                                   </tr>';
     foreach ($criteria as $criterium) 
     {    echo                    '<tr>
                                        <td>' . $criterium['Criterium'] . '</td>
                                        <td>' . $criterium['Waarde'] . '</td>
                                        <td class="button-column">                                        
                                             <form action="mijncriteriumedit.php">                             
                                                  <button type="submit" class="action-button" id="edit" name="edit" 
                                                          value="' . $criterium['CID'] . '" title="Dit criterium wijzigen.">...</button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>
                                        <td>
                                             <form action="mijncriteriummin.php">     
                                                  <button type="submit" class="action-button" id="wis" name="wis" 
                                                          value="' . $criterium['CID'] . '" title="Dit criterium verwijderen.">&nbsp;-&nbsp;</button>
                                                  <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                             </form>
                                        </td>

                                   </tr>';
     }
     echo                    '</table>
                         </div>
                         
                         <div id="account" class="tab-pane fade">
                              <div class="container">
                                   <div class="col-sm-4 col-md-6 col-lg-4 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">                                     
                                        <form action="relatieupd.php" method="GET">
                                             <h3>Mijn account</h3>
                                             <div class="form-group">
                                                  <label for="Naam">Naam:</label>
                                                  <input type="text" class="form-control" 
                                                         id="Naam" name="Naam"
                                                         value="' . $gegevens["Naam"] . '" placeholder="Naam" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="Email">E-mail adres:</label>
                                                  <input type="email" class="form-control" 
                                                         id="Email" name="Email"
                                                         value="' . $gegevens["Email"] . '" placeholder="E-mail adres" 
                                                         pattern="' . $emailpattern . '"required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="Telefoon">Telefoon:</label>
                                                  <input type="tel" class="form-control" id="Telefoon" name="Telefoon" 
                                                         value="' . $gegevens["Telefoon"] . '" placeholder="Telefoonnummer" 
                                                         pattern="' . $telefoonpattern . '" required>
                                             </div>
                                             <div class="form-group">
                                                  <label for="Wachtwoord">Wachtwoord:</label>
                                                  <input type="password" class="form-control" 
                                                         id="Wachtwoord" name="Wachtwoord" 
                                                         placeholder="Nieuw wachtwoord">
                                             </div>
                                             <div class="form-group">
                                                  <button type="submit" class="action-button" id="upd" name="upd" 
                                                          value="' . $relatieid . '" title="Mijn account aanpassen.">Wijzigen
                                                  </button>
                                                  <button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Annuleren</a></button>
                                             </div>
                                             <div class="form-group">
                                                  <button class="action-button button-column" 
                                                          title="Je Ultima Casa account verwijderen!">
                                                       <a href="accountmin.php?ID=' . $relatieid . '">Account verwijderen</a>
                                                  </button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </body>
     </html>';
?>