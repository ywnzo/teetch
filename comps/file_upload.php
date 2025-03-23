<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/teetch/config/db_connect.php';

$dir = '../public/storage/uploads/';
$uploadOk = 1;
$fileNames = [];
$classID = isset($_POST['classID']) ? $_POST['classID'] : null;
$lessonID = isset($_POST['lessonID']) ? $_POST['lessonID'] : '';
$ownerID = $_COOKIE['userID'];
$table = isset($_POST['table']) ? $_POST['table'] : null;

if (!isset($classID) || !isset($ownerID) || !isset($table)) {
    die("Missing required parameters.");
}

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
        if($lessonID !== '') {
            $sql = "INSERT INTO $table (classID, lessonID, ownerID, file) values ('$classID', '$lessonID', '$ownerID', '$fileName')";
        } else {
            $sql = "INSERT INTO $table (classID, ownerID, file) values ('$classID', '$ownerID', '$fileName')";
        }
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
