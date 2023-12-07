<?php
     include_once("functions.php");

     $db = ConnectDB();
     
     $naam = $_GET['Naam'];
     $email = $_GET['Email'];
     $telefoon = $_GET['Telefoon'];
     $wachtwoord = $_GET['Wachtwoord'];
     
     $sql = "INSERT INTO relaties (Naam, Email, Telefoon, Wachtwoord)
                  VALUES ('" . $naam . "', '" . 
                               $email . "', '" .
                               $telefoon . "', '" . 
                               md5($wachtwoord) . "')";
     
     if ($db->query($sql) == true) 
     {    if (StuurMail($email, 
                        "Account gegevens Ultima Casa", 
                        "Uw inlog gegevens zijn:
                        
               Naam: " . $naam . "
               E-mailadres: " . $email . "
               Telefoon: " . $telefoon . "
               Wachtwoord: " . $wachtwoord . "
               
               Bewaar deze gegevens goed!
               
               Met vriendelijke groet,
               
               Het Ultima Casa team.",
                        "From: noreply@uc.nl"))
          {    $result = 'De gegevens zijn naar uw e-mail adres verstuurd.';
          }
          else
          {    $result = 'Fout bij het versturen van de e-mail met uw gegevens.';
          }
     }
     else
     {    $result .= 'Fout bij het bewaren van uw gegevens.<br><br>' . $sql;
     }
     echo $result . '<br><br>
          <button class="action-button"><a href="index.html">Ok</a></button>';
?>