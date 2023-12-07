<?php
     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieID = $_GET["RID"]; 
     
     $CrVanTem = "NULL";
     $Van = "NULL";
     $Tem = "NULL";
     $vals = "";
     if (isset($_GET['CrVanTem']) && 
         (!empty($_GET['CrVanTem'])))
     {    $CrVanTem = $_GET['CrVanTem'];
          if (isset($_GET['Van']) && 
              (!empty($_GET['Van'])))
          {    $Van = $_GET['Van'];
          }
          if (isset($_GET['Tem']) && 
              (!empty($_GET['Tem'])))
          {    $Tem = $_GET['Tem'];
          }
          $vals = '(' . $Van . ',' . $Tem . ',' . $relatieID . ',' . $CrVanTem . ')';
     }
     
     $CrJaNee = "NULL";
     $Van = "NULL";
     $Tem = "NULL";
     if (isset($_GET['CrJaNee']) && 
         (!empty($_GET['CrJaNee'])))
     {    $CrJaNee = $_GET['CrJaNee'];
          if (isset($_GET['JaNee']) && 
              (!empty($_GET['JaNee'])))
          {    $Van = $_GET['JaNee'];
          }
          if ($vals != "")
          {    $vals .= ",";
          };
          $vals .= '(' . $Van . ',' . $Tem . ',' . $relatieID . ',' . $CrJaNee . ')';
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
     if (($CrVanTem != "NULL") || ($CrJaNee != "NULL"))
     {    $sql = "INSERT 
                    INTO mijncriteria (Van, Tem, FKrelatiesID, FKcriteriaID)
                  VALUES $vals";
     
          if ($db->query($sql) == true) 
          {    echo          '<p>De zoekcriteria zijn toegevoegd.</p>';
          }
          else
          {    echo          '<p>Fout bij het toevoegen van de zoekcriteria.</p>
                              <p>' . $sql . '</p>';
          }
     }
     else
     {    echo '<p>Er zijn geen nieuwe zoekcriteria toegevoegd.</p>';
     }
     echo               '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatieID . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>