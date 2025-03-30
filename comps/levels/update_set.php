<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php';

if(!isset($_POST['ID']) || !isset($_POST['name'])) {
    die("Invalid request");
}

$ID = htmlspecialchars($_POST['ID']);
$name = htmlspecialchars($_POST['name']);

$sql = "UPDATE levelSets SET name = '$name' WHERE ID = '$ID' AND ownerID = '{$_COOKIE['userID']}'";
$mssg = mysqli_query($conn, $sql) ? "Record updated successfully: " . $name : "Error updating record: " . mysqli_error($conn);
echo $mssg;


?>
