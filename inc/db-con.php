<?php
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "root"); // Empty username
define("MYSQL_PASSWORD", ""); // Empty password
define("MYSQL_DATABASE", "abdukgc");

$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD) 
    or die('I cannot connect to the database because 1: ' . $mysqli->error);

$mysqli->select_db(MYSQL_DATABASE) 
    or die('I cannot connect to the database because 2: ' . $mysqli->error);
?>
