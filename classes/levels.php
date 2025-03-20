<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'admin', 'Pecinka21*', 'teecheroo');
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

class Levels {

    public static function get_levels($cols, $params) {
        global $conn;
        $query = "SELECT $cols FROM levels WHERE $params";
        $result = mysqli_query($conn, $query);
        if(!$result) {
            return "Query error: " . mysqli_error($conn);
        }
        $levels = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $levels;
    }

    public static function get_level_count($params) {
        global $conn;
        $query = "SELECT COUNT(*) as count FROM levels WHERE $params";
        $result = mysqli_query($conn, $query);
        if(!$result) {
            return "Query error: " . mysqli_error($conn);
        }
        $count = mysqli_fetch_row($result)[0];
        return $count;
    }

    public static function insert_level($columns, $values) {
        global $conn;
        $query = "INSERT INTO levels ($columns) VALUES ($values)";
        $result = mysqli_query($conn, $query);
        if(!$result) {
            return "Query error: " . mysqli_error($conn);
        }
        return mysqli_insert_id($conn);
    }

    public static function update_level($values, $params) {
        global $conn;
        $query = "UPDATE levels SET $values WHERE $params";
        $result = mysqli_query($conn, $query);
        if(!$result) {
            return "Query error: " . mysqli_error($conn);
        }
        return mysqli_affected_rows($conn);
    }
}

?>
