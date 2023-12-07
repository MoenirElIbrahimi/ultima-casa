<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     
     $sql = "SELECT ID, Criterium, Type
               FROM criteria
              WHERE Type = 1
           ORDER BY Volgorde";
     
     $crwaarde = $db->query($sql)->fetchAll();
     
     $sql = "SELECT ID, Criterium, Type
               FROM criteria
              WHERE Type = 2
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
                    <h3 class="cell-center bbottom">Huis te koop aanbieden</h3>
                    <form action="verkoopins.php" method="GET">
                         <div class="row">
                              <div class="col-sm-4 col-md-4 col-lg-4">
                                   <div class="form-group">
                                        <label for="StartDatum">Te koop sinds:</label>
                                        <input type="text" class="form-control" value="Vandaag" id="StartDatum" name="StartDatum" readonly>
                                   </div>
                                   <div class="form-group">
                                        <label for="Straat">Straat en huisnummer:</label>
                                        <input type="text" class="form-control" placeholder="Straat en huisnummer" id="Straat" name="Straat" required>
                                   </div>
                                   <div class="form-group">
                                        <label for="Postcode">Postcode:</label>
                                        <input type="text" class="form-control" 
                                               placeholder="Postcode" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" 
                                               id="Postcode" name="Postcode" required>
                                   </div>
                                   <div class="form-group">
                                        <label for="Plaats">Plaats:</label>
                                        <input type="text" class="form-control" placeholder="Plaats" id="Plaats" name="Plaats" required>
                                   </div>
                              </div>
                              <div class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">';                              
     foreach ($crwaarde as $criterium) 
     {    echo                    '<div class="form-group form-inline">
                                        <label class="fixed-label">' . $criterium["Criterium"] . '</label>
                                        <input type="number" size=10 class="form-control input-sm"
                                               min=0 max=10000000
                                               id="CR_' . $criterium["ID"] . '" name="CR_' . $criterium["ID"] . '">
                                   </div>';
     };
     echo                    '</div>
                              <div class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">';                              
     foreach ($crjanee as $criterium) 
     {    echo                    '<div class="form-group form-inline">
                                        <label for="CR_' . $criterium["ID"] . '" class="fixed-label">' . $criterium["Criterium"] . '</label>
                                        <input type="checkbox" value=1 id="CR_' . $criterium["ID"] . '" name="CR_' . $criterium["ID"] . '">
                                   </div>';
     };
echo               '          </div>
                         </div>
                         <div class="row text-center">
                              <div class="form-group btop">
                                   <button type="submit" class="action-button" id="RID" name="RID" 
                                           value="' . $relatieid . '" title="Dit huis te koop aanbieden.">Toevoegen
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