<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/db_connect.php';

$dir = $_SERVER['DOCUMENT_ROOT'] . '/public/storage/uploads/';
$uploadOk = 1;
$fileName = [];
$userID = htmlspecialchars($_COOKIE['userID']);
$table = isset($_POST['table']) ? $_POST['table'] : null;

if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        die("Error creating directory.");
    }
}

$logFile = '../logs/upload_log.txt';
$log = fopen($logFile, 'a') or die("Cannot open log file.");

print_r($_FILES);

$filename = uniqid('', true) . '_' . htmlspecialchars($_FILES['file']['name']);
if (move_uploaded_file($_FILES['file']['tmp_name'], $dir . $filename)) {
    fwrite($log, "File uploaded: $filename\n");
} else {
    fwrite($log, "Error uploading file: " . $_FILES['file']['name'] . " - Error code: " . $_FILES['file']['error'] . "\n");
    $uploadOk = 0;
    echo "Error uploading file: " . $_FILES['file']['name'] . "<br>";
}

fclose($log);

$path = 'public/storage/uploads/' . $filename;

if ($uploadOk == 1) {
    $currentImage = DB::select('image', 'users', "ID = '$userID'")['image'];
    if(isset($currentImage) && !empty($currentImage)) {
        if(file_exists($dir . $currentImage)) {
            unlink($dir . $currentImage);
        }
    }

    $sql = "UPDATE users SET image = '$path' WHERE ID = '$userID'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Error inserting data into database.");
    }

    mysqli_close($conn);
    die('Files uploaded successfully.');
} else {
    die("File(s) failed to upload. Check the log for more details.");
}
?>
