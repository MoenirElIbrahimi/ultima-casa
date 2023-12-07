<?php
     include_once("functions.php");
     
     $relatieid = $_GET['RID'];
     
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
                         <h3>Een rol toevoegen</h3>
                         <form action="rolins.php" method="GET">
                              <div class="form-group">
                                   <label for="Naam">Rol:</label>
                                   <input type="text" class="form-control" placeholder="Rol" id="Naam" name="Naam" required>
                              </div>
                              <div class="form-group">
                                   <label for="Omschrijving">Omschrijving:</label>
                                   <input type="text" class="form-control" placeholder="Omschrijving" id="Omschrijving" name="Omschrijving" required>
                              </div>
                              <div class="form-group">
                                   <label for="Waarde">Waarde:</label>
                                   <input type="number" class="form-control" 
                                          min=0 max=127
                                          id="Waarde" name="Waarde" required>
                              </div>
                              <div class="form-group">
                                   <label for="Landingspagina">Landingspagina:</label>
                                   <input type="text" class="form-control" placeholder="Landingspagina" id="Landingspagina" name="Landingspagina" required>
                              </div>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="RID" name="RID" 
                                           value="' . $relatieid . '" title="Rol toevoegen.">Toevoegen
                                   </button>
                                   <button class="action-button">
                                        <a href="admin.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>
          </body>
     </html>';

?>