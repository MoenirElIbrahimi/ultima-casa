<?php
function ConnectDB()
{    return new PDO('mysql:host=localhost;dbname=ultima_casa;charset=utf8', 'root', '');
}
?>

