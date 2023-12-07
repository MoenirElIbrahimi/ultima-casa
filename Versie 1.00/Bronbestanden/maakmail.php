<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $fromid = $_GET["FID"];
     $toid = $_GET["TID"];
     $relatieid = $_GET["RID"];
    
     $sql = "SELECT Naam, Email
               FROM relaties
              WHERE relaties.ID = " . $toid;
     
     $to = $db->query($sql)->fetch();
     
     $sql = "SELECT Naam, Email
               FROM relaties
              WHERE relaties.ID = " . $fromid;
     
     $from = $db->query($sql)->fetch();

     $sql = "SELECT Landingspagina
               FROM relaties
          LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
              WHERE relaties.ID = " . $relatieid;
     
     $annuleren = $db->query($sql)->fetch();

     
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
                    <div class="container">
                         <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                              <h4>Stuur een e-mail aan:</h4><h3> ' . $to["Naam"] . '</h3>
                              <form action="stuurmail.php" method="POST" enctype="multipart/form-data" class="kader">
                                   <div class="form-group spacer-top">
                                        <label for="Onderwerp">Onderwerp</label>
                                        <input type="text" id="Onderwerp" name="Onderwerp" style="width:100%" required>                                   
                                   </div>
                                   <div class="form-group">
                                        <label for="Body">Tekst</label>
                                        <textarea maxlength="6000" rows=7 name="Body" id="Body" required></textarea>
                                   </div>
                                   <div class="form-group">
                                        <label for="Bijlagen">Bijlagen:</label>
                                        <input type="file" id="Bijlagen" name="Bijlagen[]" multiple>
                                   </div>
                              </div>
                              <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4 spacer-top">
                                   <div class="form-group">
                                        <button type="submit" class="action-button" id="TID" name="TID" 
                                                value="' . $toid . '" title="Deze e-mail versturen.">Versturen
                                        </button>
                                        <input type="hidden" value="' . $fromid . '" id="FID" name="FID">
                                        <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                        <button class="action-button"><a href="' . $annuleren["Landingspagina"] . '?RID=' . $relatieid . '" >Annuleren</a>
                                        </button>
                                   </div>
                              </div>    
                         </form>
                    </div>
               </div> 
          </body>
     </html>';
?>