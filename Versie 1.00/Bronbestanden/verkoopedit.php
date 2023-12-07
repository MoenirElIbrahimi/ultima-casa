<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $huizenid = $_GET['HID'];
     $relatieid = $_GET['RID'];
     
     $sql = "SELECT ID as AID, StartDatum, FKrelatiesID, Straat, Postcode, Plaats
               FROM huizen
              WHERE huizen.ID = $huizenid";
     $huis = $db->query($sql)->fetch();
     
     $sql = "  SELECT * FROM criteria cr
             LEFT JOIN (SELECT ID as HCID, FKcriteriaID, FKhuizenID, Waarde FROM huiscriteria 
                         WHERE FKhuizenID = $huizenid) AS hc ON hc.FKcriteriaID = cr.ID
                WHERE cr.Type = 1
             ORDER BY Volgorde";
     
     $crwaarde = $db->query($sql)->fetchAll();
     
     $sql = "  SELECT * FROM criteria cr
             LEFT JOIN (SELECT ID as HCID, FKcriteriaID, FKhuizenID, Waarde FROM huiscriteria 
                         WHERE FKhuizenID = $huizenid) AS hc ON hc.FKcriteriaID = cr.ID
                WHERE cr.Type = 2
             ORDER BY Volgorde";
     
     $crjanee = $db->query($sql)->fetchAll();
         
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
                    <h3 class="cell-center bbottom">Huis te koop wijzigen</h3>
                    <form action="verkoopupd.php" method="GET">
                         <input type="hidden" value="' . $huis["AID"] . '" id="AID" name="AID">
                         <input type="hidden" value="' . $huizenid . '" id="HID" name="HID">
                         <div class="row">
                              <div class="col-sm-4 col-md-4 col-lg-4">
                                   <div class="form-group">
                                        <label for="StartDatum">Te koop sinds:</label>
                                        <input type="text" class="form-control" value="' . $huis["StartDatum"] . '" id="StartDatum" name="StartDatum" readonly>
                                   </div>
                                   <div class="form-group">
                                        <label for="Straat">Straat en huisnummer:</label>
                                        <input type="text" class="form-control" value="' . $huis["Straat"] . '" id="Straat" name="Straat" required>
                                   </div>
                                   <div class="form-group">
                                        <label for="Postcode">Postcode:</label>
                                        <input type="text" class="form-control" 
                                               value="' . $huis["Postcode"] . '" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" 
                                               id="Postcode" name="Postcode" required>
                                   </div>
                                   <div class="form-group">
                                        <label for="Plaats">Plaats:</label>
                                        <input type="text" class="form-control" value="' . $huis["Plaats"] . '" id="Plaats" name="Plaats" required>
                                   </div>
                              </div>
                              <div class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">';                              
     foreach ($crwaarde as $criterium) 
     {    echo                    '<div class="form-group form-inline">
                                        <label class="fixed-label">' . $criterium["Criterium"] . '</label>
                                        <input type="number" size=10 class="form-control input-sm"
                                               value="' . $criterium["Waarde"] . '"
                                               min=0 max=10000000
                                               id="CR_' . $criterium["ID"] . '" name="CR_' . $criterium["ID"] . '">
                                   </div>';
     };
     echo                    '</div>
                              <div class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">';                              
     foreach ($crjanee as $criterium) 
     {    $checked = '';
          if ($criterium["Waarde"])
          {     $checked = 'checked';
          }
          echo                    '<div class="form-group form-inline">
                                        <label for="CR_' . $criterium["ID"] . '" class="fixed-label spacer-right">' . $criterium["Criterium"] . '</label>
                                        <input type="checkbox" class="big-checkbox" value=1 ' . $checked . ' id="CR_' . $criterium["ID"] . '" name="CR_' . $criterium["ID"] . '">
                                   </div>';
     };
echo               '          </div>
                         </div>
                         <div class="row text-center">
                              <div class="form-group btop">
                                   <button type="submit" class="action-button" id="RID" name="RID" 
                                           value="' . $relatieid . '" title="De gegevens van deze koop wijzigen.">Wijzigen
                                   </button>
                                   <button class="action-button">
                                        <a href="relatie.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </div>
                    </form>
               </div>
          </body>
     </html>';

?>