<?php

$dbhost = '127.0.0.1'; // localhost
$dbuname = 'root';
$dbpass = '';    // CHANGE THIS!!!! It was initially 'root'
$dbname = 'RecipeDB'; //Database name

$dbo = new PDO('mysql:host=' . $dbhost . ';port=8809;dbname=' . $dbname, $dbuname, $dbpass);

?>
