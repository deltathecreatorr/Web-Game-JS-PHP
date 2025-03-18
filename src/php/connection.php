<?php

$host = 'localhost';
$dbname = 'leaderboard_db';
$dbuser = 'root';
$dbpass = '';


$connection = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($connection -> connect_error) {
    die('Connection failed: ' . $connection -> connect_error);
}


?>