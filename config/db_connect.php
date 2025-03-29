<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/teetch/config/config.ini', true);
$host = $config['db']['host'];
$user = $config['db']['user'];
$password = $config['db']['password'];
$database = $config['db']['database'];

$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

include($_SERVER['DOCUMENT_ROOT'] . '/teetch/classes/db.php');

?>
