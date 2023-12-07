<?php

     include_once("functions.php");
     
     $db = ConnectDB();
     
     $relatieid = $_GET["RID"]; 
     $adresid = $_GET["AID"];
     $huisid = $_GET["HID"];
     
     $straat = "'" . trim($_GET["Straat"]) . "'";
     $postcode = "'" . strtoupper(str_replace(' ', '', $_GET["Postcode"])) . "'";
     $plaats = "'" . trim($_GET["Plaats"]) . "'";
     
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
                         <h3>Huis te koop aanbieden.</h3>';
     
     $sql = "UPDATE adressen 
                SET Straat = $straat, 
                    Postcode = $postcode, 
                    Plaats = $plaats
              WHERE ID = $adresid";
     $fout = $sql;
     $db->beginTransaction();
     if ($db->query($sql) == true)
     {    $sql = "DELETE 
                    FROM huiscriteria 
                   WHERE FKhuizenID = $huisid"; 
          $fout = $sql;        
          if ($db->query($sql) == true)
          {    $sqlarr = array();
               foreach ($_GET as $arg=>$val) 
               {    $cr = explode("_", $arg);
                    if (count($cr) == 2)
                    {    if (($cr[0] == "CR") && (!empty($_GET[$arg])))
                         {    $sqlarr[] = "(" . $val . "," . $huisid . "," . $cr[1] . ")";
                         }
                    }
               }
               if (count($sqlarr) > 0)
               {    $sql = "INSERT INTO huiscriteria (Waarde, FKhuizenID, FKcriteriaID)
                            VALUES " . implode(',', $sqlarr);
                    $fout = $sql; 
                    if ($db->query($sql) == true)
                    {    $fout = "--";
                    }
               }
               else
               {    $fout = "--";
               }
          }
     }
     if ($fout == '--')
     {    $db->commit();
          $text = "<p>De verkoopgegevens zijn gewijzigd.</p>";
     }
     else
     {    $db->rollback();
          $text = '<p>Fout bij het wijizigen van de verkoopgegevens.</p>
                   <p>' . $sql . '</p>';
     }
     echo $text .       '<br><br>
                         <button class="action-button"><a href="relatie.php?RID=' . $relatieid . '" >Ok</a>
                         </button>
                    </div>
               </div>
          </body>
     </html>';
?>