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
                         <h3>Een status toevoegen</h3>
                         <form action="statusins.php" method="GET">
                              <div class="form-group">
                                   <label for="Statuscode">Statuscode:</label>
                                   <input type="number" class="form-control" 
                                          min=0 max=127
                                          id="Statuscode" name="Statuscode" required>
                              </div>
                              <div class="form-group">
                                   <label for="Status">Status:</label>
                                   <input type="text" class="form-control" placeholder="Status" id="Status" name="Status" required>
                              </div>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="RID" name="RID" 
                                           value="' . $relatieid . '" title="Status toevoegen.">Toevoegen
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