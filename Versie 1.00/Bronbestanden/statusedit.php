<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET['RID'];
     $id = $_GET['edit'];
     

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
                         <h3>Status wijzigen</h3>';
                         
     $sql = "SELECT StatusCode, Status 
               FROM statussen 
              WHERE ID = $id";
              
     $record = $db->query($sql)->fetch();
     
     if ($record)
     {    echo          ' <form action="statusupd.php" method="GET">
                              <div class="form-group">
                                   <label for="StatusCode">Statuscode:</label>
                                   <input type="number" min=0 max=127 class="form-control" value = "' . $record["StatusCode"] . '"
                                          id="StatusCode" name="StatusCode" required>
                              </div>
                              <div class="form-group">
                                   <label for="Status">Status:</label>
                                   <input type="text" class="form-control" value="' . $record["Status"] . '" 
                                          id="Status" name="Status" required>
                              </div>
                              <div class="form-group">
                                   <button type="submit" class="action-button" id="ID" name="ID" 
                                           value="' . $id . '" title="Status wijzigen.">Wijzigen
                                   </button>
                                   <input type="hidden" value="' . $relatieid . '" id="RID" name="RID">
                                   <button class="action-button">
                                        <a href="admin.php?RID=' . $relatieid . '" >Annuleren</a>
                                   </button>
                              </div>
                         </form>';
     }
     else
     {         echo     'Fout bij het ophalen van de gegevens<br><br>
                         <button class="action-button"><a href="admin.php?RID=' . $relatieid . '" >Ok</a>
                         </button>';
     }
     echo          '</div>
               </div>
          </body>
     </html>';

?>