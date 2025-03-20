<?php 

class DB {
    static function query($sql) {
        global $conn;
        $result = mysqli_query($conn, $sql);
        if(!is_bool($result)) {
            if(!$result) {
                echo 'Error occured!';
                return false;
            } else {
                $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
                if(is_array($result) && count($result) > 1 || !is_array($result)) {
                    return $result;
                }
                if(is_array($result) && count($result) == 1) { 
                    return $result[0];
                }
            }
        }
    }

    public static function select($columns, $table, $params) {
        $sql = "SELECT $columns FROM $table WHERE $params";
        return self::query($sql);
    }

    public static function update($table, $values, $params) {
        $sql = "UPDATE $table SET $values WHERE $params";
        return self::query($sql);
    }

    public static function delete($table, $params) {
        $sql = "DELETE FROM $table WHERE $params";
        return self::query($sql);
    }

    public static function insert($table, $properties, $values) {
        $sql = "INSERT INTO $table ($properties) VALUES ($values)";
        return self::query($sql);
    }
}

?>