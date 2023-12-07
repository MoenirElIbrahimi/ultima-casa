<?php
     include_once("functions.php");

     $db = ConnectDB();

     $relatieid = $_POST["RID"];
     $fromid = $_POST["FID"];
     $toid = $_POST["TID"];

     
     $onderwerp = $_POST['Onderwerp'];
     $body = $_POST['Body'];
      
     $sql = "SELECT Naam, Email
               FROM relaties
              WHERE relaties.ID = " . $toid;
     
     $to = $db->query($sql)->fetch();
     
     $sql = "SELECT Naam, Email
               FROM relaties
              WHERE relaties.ID = " . $fromid;
     
     $from = $db->query($sql)->fetch();

     $sql = "SELECT Landingspagina
               FROM relaties
          LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
              WHERE relaties.ID = " . $relatieid;
     
     $terug = $db->query($sql)->fetch();
     
     $smail = $from['Email'];
     $snaam = $from['Naam'];
     $email = $to["Email"];
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
                              <h3>E-mail versturen</h3>';
                              
     $bijlagen = array();
     if (isset($_FILES['Bijlagen'])) 
     {    $bijlagen = $_FILES['Bijlagen'];
     }
     
     if (StuurMailMetBijlagen($email, $onderwerp, $body, $smail, $snaam, $bijlagen))
     {    echo               '<p>De e-mail is verstuurd.</p>';
     }
     else
     {    echo               '<p>Fout bij het versturen van de e-mail.</p>';
     };
     
     echo                    '<br><br>
                              <button class="action-button"><a href="' . $terug["Landingspagina"] . '?RID=' . $relatieid . '" >Ok</a>
                              </button>
                         </div>
                    </div>
               </body>
          </html>';
?>