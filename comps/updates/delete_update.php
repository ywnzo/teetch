<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'teecheroo');
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

if(!isset($_POST['updateID']) || !isset($_POST['classID'])) {
    die("Invalid request");
}

$table = isset($_POST['lessonID']) ? 'lessonUpdates' : 'classUpdates';
$updateID = $_POST['updateID'];
$lessonID = isset($_POST['lessonID']) ? $_POST['lessonID'] : null;

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
