<?php

include $_SERVER['DOCUMENT_ROOT'] . '/teetch/config/db_connect.php';

if(!$conn) {
    die($_SERVER['DOCUMENT_ROOT'] . '/teetch/config/db_connect.php');
}

if(!isset($_POST['setID'])) {
    die("Invalid request");
}

$setID = htmlspecialchars($_POST['setID']);

$sql = "SELECT * FROM levels WHERE setID = '$setID' AND ownerID = '{$_COOKIE['userID']}' ORDER BY setOrder";
$result = mysqli_query($conn, $sql);

if(!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$result = json_encode($result);
echo $result;

?>
