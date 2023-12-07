<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $biedingenID = $_GET["wis"]; 
     $relatiesID = $_GET["RID"]; 
     echo 
    '<!DOCTYPE html>
     <html lang="nl">
          <head>
               <title>Ultima Casa Beheer</title>
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
                         <h3>Huis van de markt halen</h3>';
     
     $sql = "   DELETE 
                  FROM huizen
                 WHERE ID = $biedingenID"; // cascade => biedingen, huiscriteria

     if ($db->query($sql) == true) 
     {    echo 'Het huis is van de markt gehaald.';
     }
     else
     {    echo 'Fout bij het van de markt halen van het huis.<br><br>' . $sql;
     }
    
     echo               '<br><br>
                         <button class="action-button"><a href="beheer.php?RID=' . $relatiesID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>