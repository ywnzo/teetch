<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php';

if(!isset($_POST['updateID']) || !isset($_POST['text']) || !isset($_POST['content'])) {
    die("Invalid request");
}

$updateID = htmlspecialchars($_POST['updateID']);
$text = htmlspecialchars($_POST['text']);
$content = htmlspecialchars($_POST['content']);
$table = htmlspecialchars($_POST['table']);

if($content === 'link') {
    $sql = "UPDATE $table SET link = '$text' WHERE ID = '$updateID' AND ownerID = '{$_COOKIE['userID']}'";
} elseif($content === 'text') {
    $sql = "UPDATE $table SET text = '$text' WHERE ID = '$updateID' AND ownerID = '{$_COOKIE['userID']}'";
}

$mssg = mysqli_query($conn, $sql) ? "Record updated successfully: " . $content : "Error updating record: " . mysqli_error($conn);
echo $mssg;

?>
