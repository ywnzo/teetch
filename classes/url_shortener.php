<?php

class USHORT {

    public static $urlBase = 'http://localhost/flard?url=';
    static function get_conn() {
        $conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'flard');
        if(!$conn) {
            echo "Connection error: " . mysqli_connect_error();
        }
        return $conn;
    }
    

    public static function shorten($url) {
        $conn = self::get_conn();
        if(!$conn) {
            return false;
        }

        $id = uniqid();
        $urlShort = self::$urlBase . $id;

        $sql = "INSERT INTO urls (original, short) VALUES ('$url', '$id')";
        if(mysqli_query($conn, $sql)) {
            return $urlShort;
        } else {
            return false;
        }
    }
}

?>