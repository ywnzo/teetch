<?php 

include('config/db_connect.php');
$sessionID = $_COOKIE['sessionID'];
if(isset($_COOKIE['sessionID'])) {
    $sql = "UPDATE users SET sessionID = '' WHERE sessionID = '$sessionID'";
    mysqli_query($conn, $sql);
    setcookie("sessionID", "", time() - 3600, "/");    
    header('Location: index.php');
}

?>