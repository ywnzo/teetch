<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'teecheroo');
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
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
