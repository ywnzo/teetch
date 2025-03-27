<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/teetch/config/db_connect.php';

if(!isset($_POST['updateID']) || !isset($_POST['classID'])) {
    die("Invalid request");
}

$table = isset($_POST['lessonID']) ? 'lessonUpdates' : 'classUpdates';
$updateID = htmlspecialchars($_POST['updateID']);
$lessonID = isset($_POST['lessonID']) ? htmlspecialchars($_POST['lessonID']) : null;

$sql = "SELECT file FROM $table WHERE ID = '$updateID'";
$update = mysqli_query($conn, $sql);
$update = mysqli_fetch_assoc($update);

if (!isset($update)) {
    die("Query error: " . mysqli_error($conn));
}

if(isset($update['file'])) {
    unlink('../../public/storage/uploads/' . $update['file']);
}

$sql = "DELETE FROM $table WHERE ID = '$updateID' AND ownerID = '{$_COOKIE['userID']}'";
if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

?>
