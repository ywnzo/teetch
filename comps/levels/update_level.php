<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'teecheroo');
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

if(!isset($_POST['ID']) || !isset($_POST['name'])) {
    die("Invalid request");
}

$ID = htmlspecialchars($_POST['ID']);
$name = htmlspecialchars($_POST['name']);

$sql = "UPDATE levels SET name = '$name' WHERE ID = '$ID' AND ownerID = '{$_COOKIE['userID']}'";
$mssg = mysqli_query($conn, $sql) ? "Record updated successfully: " . $name : "Error updating record: " . mysqli_error($conn);
echo $mssg;


?>
