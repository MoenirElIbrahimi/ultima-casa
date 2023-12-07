<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $id = $_GET["upd"]; 
     $relatieID = $_GET["RID"]; 
     $van = "NULL";
     if (isset($_GET['Van']))
     {    $van = $_GET['Van'];
     }
     $tem = "NULL";
     if (isset($_GET['Tem']))
     {    $tem = $_GET['Tem'];
     }
     
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
                         <h3>Mijn zoekcriterium wijzigen</h3>';
     
     $sql = "UPDATE mijncriteria 
                SET Van = " . $van . ",
                    Tem = " . $tem . "
              WHERE ID = $id";
     
     if ($db->query($sql) == true) 
     {    echo          '<p>Het criterium is aangepast.</p>';
     }
     else
     {    echo          '<p>Fout bij het bewaren van het criterium.</p>
                         <p>' . $sql . '</p>';
     }
     echo               '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatieID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>