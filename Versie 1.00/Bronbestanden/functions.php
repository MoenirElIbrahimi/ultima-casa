<?php

include_once("DBUC.php");

$telefoonpattern = "^(?:0|\(?\+31\)?\s?|0031\s?)[1-79](?:[\.\-\s]?\d\d){4}$";

$emailpattern = "(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|" . '"' . 
                "(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*" . '"' .
                ")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:" .
                "(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]" .
                "*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])";


function ActionButton($caption, $action, $actionvalue = NULL, $title = NULL, $novalidate = NULL)
{    $result = '<button type="submit" class="action-button"  
                        id="button_' . $action . '" name="button_' . $action . '"';
     if ($novalidate)
     {    $result .=  ' formnovalidate';
     }
     if ($actionvalue)
     {    $result .= ' value="' . $actionvalue . '"';
     };
     if ($title)
     {    $result .= ' title="' . $title . '"';
     };
     $result .= '>' . $caption . '</button>';
     return $result;
}

function GetAction()
{    $action = NULL;
     foreach($_POST as $name => $val) 
     {    if (!is_array($post))
          {    $names = explode("_", $name);
               if ($names[0] == "button")
               {    if (count($names) > 1)
                    {    $action = implode("_", array_slice($names, 1));
                         break;
                    }
               }
          }
     }
     $actionvalue = NULL;   
     if (!is_null($action))
     {    $actionbutton = "button_" . $action;
          if (isset($_POST[$actionbutton]))
          {    $actionvalue = $_POST[$actionbutton];
          }
     }
     return array("action" => $action, "value" => $actionvalue);
}

function MakeHead($title, $redir = "")
{    return '
     <head>
          <title>' . $title . '</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">' .
          $redir . '
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
          <link rel="stylesheet" type="text/css" href="ucstyle.css?' . mt_rand() . '">
     </head>';
};

function InlogKop($relatieid, $titel, $extracel = "")
{    $db = ConnectDB();
     
     $sql = "SELECT relaties.Naam AS Naam, Email, Telefoon, Omschrijving
               FROM relaties
          LEFT JOIN rollen ON rollen.ID = relaties.FKrollenID
              WHERE relaties.ID = " . $relatieid;
     
     $ingelogals = $db->query($sql)->fetch();
 
     return 
         '<table id="inlog_gegevens">
               <tr>
                    <td><h3>' . $titel . '</h3></td>
                    <td class="text-right">' . $ingelogals["Omschrijving"] . '</td>
                    <td>' . $ingelogals["Naam"] . '<br>' . 
                            $ingelogals["Email"] . '<br>' . 
                            $ingelogals["Telefoon"] .
                   '</td>
                    <td>                                                                             
                         <button class="action-button button-column">
                              <a href="index.php">Uitloggen</a>
                         </button>
                    </td>' .
                    $extracel .
              '</tr>
          </table>';
}


function StuurMail($aan, $onderwerp, $mailbody, $headers)
{    return mail($aan, $onderwerp, $mailbody, $headers);
}

function StuurMailMetBijlagen($to, $subject, $message, $senderEmail, $senderName, $files = array())
{    $headers = "From: " . $senderEmail . "\r\n";  
 
     // Boundary  
     $semi_rand = md5(time());  
     $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
     // Headers for attachment  
     $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . 
                 " boundary=\"{$mime_boundary}\"";  
 
     // Multipart boundary  
     $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
                "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  

     if (count($files) > 0)
     {    // Lege elementen uit $_FILES halen (php bug)
          $x = 0;
          $bijlagen = array();
          foreach($_FILES['Bijlagen']['name'] as $data)
          {    $bijlagen[$x] = array(); 
               $bijlagen[$x]['name'] = $data; 
               $x++;
          }
          $x = 0;
          foreach($_FILES['Bijlagen']['type'] as $data)
          {    $bijlagen[$x]['type'] = $data;
               $x++;
          }
          $x = 0;
          foreach($_FILES['Bijlagen']['tmp_name'] as $data)
          {    $bijlagen[$x]['tmp_name'] = $data; 
               $x++;
          }
          $x = 0;
          foreach($_FILES['Bijlagen']['error'] as $data)
          {    $bijlagen[$x]['error'] = $data; 
               $x++;
          }
          $x = 0;
          foreach($_FILES['Bijlagen']['size'] as $data)
          {    $bijlagen[$x]['size'] = $data; 
               $x++;
          }
          // Bijlagen toevoegen
          foreach ($bijlagen as $bijlage)
          {    $file_name = basename($bijlage["name"]); 
               if (!empty($file_name))
                    {
               $file_size = $bijlage["size"]; 
               $message .= "--{$mime_boundary}\n"; 
               $fp = fopen($bijlage["tmp_name"], "rb"); 
               $data = fread($fp, $file_size); 
               fclose($fp); 
               $data = chunk_split(base64_encode($data)); 
               $message .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\n" .  
                           "Content-Description: " . $file_name . "\n" . 
                           "Content-Disposition: attachment;\n" . " filename=\"" . $file_name . "\"; size=" . $file_size . ";\n" .  
                           "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
               } 
          } 
     }
     $message .= "--{$mime_boundary}--"; 
     $returnpath = "-f" . $senderEmail;
     
     return mail($to, $subject, $message, $headers, $returnpath);  
}

function FormatMessage($message, $class = "")
{    if ($message == "")
         return "";
     return '
          <div class="container bg-info text-center ' . $class . '">
               <h4>' . $message . '
               </h4>
          </div>';
}

function FormatDatum($datum = NULL)
{    if ($datum)
     {    $datum = date_create($datum);
          return date_format($datum, "Y-m-d"); 
     }
     return date("Y-m-d");   
}

?>