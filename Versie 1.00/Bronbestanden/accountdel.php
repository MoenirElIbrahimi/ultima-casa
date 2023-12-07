<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $ID = $_GET["del"]; 
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
                         <h3>Mijn account verwijderen</h3>';
                         
     
     $sql = "   DELETE 
                  FROM relaties
                 WHERE ID = $ID";
                 
     if ($db->query($sql) == true) 
     {    echo          'Mijn account is verwijderd
                         <br><br>
                         <button class="action-button"><a href="index.html" >Ok</a>
                         </button>';
     }
     else
     {    echo          'Fout bij het verwijderen van mijn account.<br><br>' . $sql .
                        '<br><br>
                              <button class="action-button"><a href="relatie.php?RID=' . $ID . '" >Ok</a>
                              </button>';
     }
    
     echo          '</div>
               </div>
          </body>
     </html>';
?>