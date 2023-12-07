<?php
     $noaccount = "";
     if (isset($_GET["NOAccount"]))
     {    $noaccount = "<h4 class='accent'><br>Onjuiste E-mail/Wachtwoord combinatie.<br><br></h4>";
     }
echo '
<!DOCTYPE html>
<html lang="nl">
     <head>
          <title>Inloggen bij Ultima Casa</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <link rel="stylesheet" type="text/css" href="ucstyle.css">
     </head>
     <body>
          <div class="container">
               <div class="col-sm-4 col-md-6 col-lg-4 col-sm-offset-4 col-md-offset-3 col-lg-offset-4">
                    <h3>Inloggen bij Ultima Casa</h3>' . 
                    $noaccount . 
                   '<form action="inloggen.php" method="GET">
                         <div class="form-group">
                              <label for="Email">E-mailadres:</label>
                              <input type="email" class="form-control" id="Email" name="Email" placeholder="E-mailadres" required>
                         </div>
                         <div class="form-group">
                              <label for="Wachtwoord">Wachtwoord:</label>
                              <input type="password" class="form-control" id="Wachtwoord" name="Wachtwoord" placeholder="Wachtwoord" required>
                         </div>
                         <div class="form-group"><button type="submit" class="action-button" title="Inloggen">Inloggen</button>
                    </form>
                    <form action="maakaccount.php" method="GET">
                         </div><br><br>
                         <h4>Nog geen account?</h4>
                         <div class="form-group"><button type="submit" class="action-button"
                              title="Maak een Ultima Casa account aan!">Maak er hier eentje aan!</button>
                         </div>
                    </form>
               </div> 
          </div>
     </body>
</html>';
?>
