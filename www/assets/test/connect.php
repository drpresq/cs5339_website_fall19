<?php 
session_start();

require_once('resources.php');

$db = mysqli_connect($database, $user, $password, null);

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo  mysqli_connect_errno() . PHP_EOL;
    echo  mysqli_connect_error() . PHP_EOL;
    exit;
}

?>