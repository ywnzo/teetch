<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/teetch/config/db_connect.php';

if(!isset($_POST['ID']) || !isset($_POST['levelID']) || !isset($_POST['name'])) {
    die("Invalid request");
}

$ID = htmlspecialchars($_POST['ID']);
$levelID = htmlspecialchars($_POST['levelID']);
$name = htmlspecialchars($_POST['name']);

$sql = "UPDATE levelRequirements SET levelID = '$levelID', name = '$name' WHERE ID = '$ID' AND ownerID = '{$_COOKIE['userID']}'";
$mssg = mysqli_query($conn, $sql) ? "Record updated successfully: " . $name : "Error updating record: " . mysqli_error($conn);
echo $mssg;


?>
