<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $biedingenID = $_GET["BID"]; 
     $relatiesID = $_GET["RID"]; 
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
                         <h3>Het bod op het huis aanpassen</h3>';
     
     $sql = "   UPDATE biedingen
                   SET Bod = " . $_GET['Bod'] . ",
                       Datum = '" . $_GET['Datum'] . "' 
                 WHERE ID = $biedingenID";

     if ($db->query($sql) == true) 
     {    echo 'Het bod is aangepast';
     }
     else
     {    echo 'Fout bij het aanpassen van het bod.<br><br>' . $sql;
     }
    
     echo               '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatiesID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>