<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET["RID"];
     
     $sql = "SELECT ID, Criterium
               FROM criteria
             WHERE (Type = 1) AND
                   ID NOT IN (SELECT FKcriteriaID 
                                FROM mijncriteria 
                               WHERE FKrelatiesID = $relatieid)
             ORDER BY Criterium";
     
     $crtsvantem = $db->query($sql)->fetchAll();
     
     $sql = "SELECT ID, Criterium
               FROM criteria
             WHERE (Type = 2) AND
                   ID NOT IN (SELECT FKcriteriaID 
                                FROM mijncriteria 
                               WHERE FKrelatiesID = $relatieid)
             ORDER BY Criterium";
     
     $crtsjanee = $db->query($sql)->fetchAll();
     
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
                    <div class="col-sm-10 col-md-8 col-lg-6 col-sm-offset-1 col-md-offset-2 col-lg-offset-3">
                         <div class="text-center">
                              <h3>Zoekcriteria toevoegen</h3>
                         </div>
                         <form action="mijncriteriumins.php" method="GET">
                              <div class="form-group form-inline">
                                   <select class="form-control" id="CrVanTem" name="CrVanTem">
                                        <option value="" selected>&lt;Selecteer een criterium&gt;</option>';
     foreach ($crtsvantem as $crvantem) 
     {    echo                         '<option value="' . $crvantem['ID'] . '">' . $crvantem['Criterium'] . '
                                        </option>';
     };
     echo                         '</select>
                                   <label for="Van" class="spacer-left">Van:</label>
                                   <input type="number" size=7 class="form-control" min=0
                                          id="Van" name="Van">
                                   <label for="Tem" class="spacer-left">T/m:</label>
                                   <input type="number" size=7 class="form-control" min=0
                                          id="Tem" name="Tem">
                              </div>
                              <br><br>
                              <div class="form-group form-inline">
                                   <select class="form-control spacer-right" id="CrJaNee" name="CrJaNee">
                                        <option value="" selected>&lt;Selecteer een criterium&gt;</option>';
     foreach ($crtsjanee as $crjanee) 
     {    echo                         '<option value="' . $crjanee['ID'] . '">' . $crjanee['Criterium'] . '
                                        </option>';
     };
     echo                         '</select>
                                   <input type="checkbox" class="big-checkbox" value=1 name="JaNee" id="JaNee" autocomplete="off">
                              </div>
                              <br><br>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="RID" name="RID" 
                                           value="' . $relatieid . '" title="Deze criteria toevoegen.">Toevoegen
                                   </button>
                                   <button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';
?>