<?php
    function get_file_name($file) {
        $filename = explode('_', $file);
        $f = '';
        for($i = 1; $i < count($filename); $i++) {
            $f = $f . $filename[$i];
        }
        return $f;
    }
    if(!isset($_GET['file'])) {
        header('Location: index.php');
        die('Filename not provided');
    }

    $file = 'public/storage/uploads/' . $_GET['file'];
    if (!file_exists($file)) {
        header('Location: index.php');
        die('File not found');
    }

    header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . get_file_name(basename($file)) . '"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	exit();
?>
