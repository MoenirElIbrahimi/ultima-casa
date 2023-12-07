<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["wis"];
     $relatieid = $_GET["RID"];
     
     $sql = "SELECT mijncriteria.ID as CID, Criterium, Van, Tem, Type
               FROM mijncriteria
          LEFT JOIN criteria ON criteria.ID = FKcriteriaID
              WHERE mijncriteria.ID = $ID";
     
     $gegevens = $db->query($sql)->fetch();
     
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
                         <h4>Mijn Ultima Casa zoekcriterium verwijderen</h4>';
                    
     if ($gegevens["Type"] == 1)
     { // Van - T/m
          echo          '<h3>' . $gegevens["Criterium"] . '</h3>
                         <div class="form-group">
                              <label for="Van">Van:</label>
                              <input type="number" class="form-control" 
                                     min=0  
                                     value="' . $gegevens["Van"] . '" id="Van" name="Van" readonly>
                         </div>
                         <div class="form-group">
                              <label for="T/m">T/m:</label>
                              <input type="number" class="form-control" value="' . $gegevens["Tem"] . '" id="Tem" name="Tem" readonly>
                         </div>';
     }
     else
     { // Ja/Nee
          $checked = "";
          if ($gegevens["Van"] > 0)
          {    $checked = " checked";
          }
          echo          '<h3>Criterium</h3>
                         <div class="form-group">
                              <label class="spacer-right">' . $gegevens["Criterium"] . '</label>
                              <input type="checkbox" class="big-checkbox" value=1 name="Van" id="Van" readonly' . $checked . '>
                         </div>';
     }
     
     echo               '<form action="mijncriteriumdel.php" method="GET">
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="del" name="del" 
                                           value="' . $ID . '" title="Dit criterium verwijderen.">Verwijderen
                                   </button>
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div> 
          </body>
     </html>';
?>