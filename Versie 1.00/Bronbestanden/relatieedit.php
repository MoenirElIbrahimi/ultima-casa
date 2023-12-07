<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["rel"];
     $relatieid = $_GET["RID"];
     
     $sql = "SELECT Naam, Email, Telefoon, FKrollenID
               FROM relaties
              WHERE relaties.ID = " . $ID;
     
     $gegevens = $db->query($sql)->fetch();
     
     $sql = "SELECT ID, CONCAT(Naam, ' - ', Omschrijving) AS Rol
               FROM rollen
           ORDER BY Waarde";
     
     $rollen = $db->query($sql)->fetchAll();

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
                    <div class="col-sm-5 col-md-7 col-lg-5 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                         <h3>Relatiedetails</h3>
                         <div class="form-group">
                              <label for="Naam">Naam:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Naam"] . '" id="Naam" name="Naam" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Telefoon">Telefoon:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Telefoon"] . '" id="Telefoon" name="Telefoon" readonly>
                         </div>
                         <div class="form-group">
                              <label for="Email">Email:</label>
                              <input type="text" class="form-control" value="' . $gegevens["Email"] . '" id="Email" name="Email" readonly>
                         </div>
                         <form action="relatierolupd.php" method="GET">
                              <div class="form-group">
                                   <label for="Rol">Rol:</label>
                                   <select class="form-control" id="Rol" name="Rol" value="' . $gegevens["FKrollenID"] . '" required>';
     foreach ($rollen as $rol) 
     {    $sel = "";
          if ($rol['ID'] == $gegevens["FKrollenID"])
          {    $sel = "selected";
          }
          echo                         '<option value="' . $rol['ID'] . '" ' . $sel . '>' . $rol['Rol'] . '
                                        </option>';
     };
     echo                         '</select>
                              </div>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="upd" name="upd" 
                                           value="' . $ID . '" title="De rol van deze relatie aanpassen.">Wijzigen
                                   </button>
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <button class="action-button"><a href="admin.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div> 
          </body>
     </html>';
?>