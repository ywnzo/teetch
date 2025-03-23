<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'teecheroo');
if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

include(getcwd() .'/classes/db.php');

?>
