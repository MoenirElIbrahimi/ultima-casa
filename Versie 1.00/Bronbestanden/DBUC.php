<?php
function ConnectDB()
{    return new PDO('mysql:host=localhost;dbname=ultima_casa_db;charset=utf8', 'root', '');
}
?>

