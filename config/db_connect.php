<?php
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini', true);
$host = $config['db']['host'];
$user = $config['db']['user'];
$password = $config['db']['password'];
$database = $config['db']['database'];

$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

include($_SERVER['DOCUMENT_ROOT'] . '/classes/db.php');

?>
