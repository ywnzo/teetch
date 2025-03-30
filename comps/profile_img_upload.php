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

foreach ($_FILES['file']['name'] as $key => $val) {
    $filename = uniqid('', true) . '_' . htmlspecialchars($_FILES['file']['name'][$key]);
    if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $dir . $filename)) {
        $fileNames[] = $filename;
        fwrite($log, "File uploaded: $filename\n");
    } else {
        fwrite($log, "Error uploading file: " . $_FILES['file']['name'][$key] . " - Error code: " . $_FILES['file']['error'][$key] . "\n");
        $uploadOk = 0;
        echo "Error uploading file: " . $_FILES['file']['name'][$key] . "<br>";
    }
}

fclose($log);

if ($uploadOk == 1) {
    foreach($fileNames as $fileName) {
        $sql = "UPDATE users SET image = '$fileName' WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Error inserting data into database.");
        }
    }

    mysqli_close($conn);
    die('Files uploaded successfully.');
} else {
    die("File(s) failed to upload. Check the log for more details.");
}
?>
