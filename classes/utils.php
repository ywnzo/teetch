<?php

class Utils {
    public static function has_string_keys(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    public static function is_today($date) {
        $givenDate = new DateTime($date);
        $today = new DateTime();
        return $givenDate->format('Y-m-d') == $today->format('Y-m-d');
    }

    public static function get_file_name($file) {
        $filename = explode('_', $file);
        $count = count($filename);
        for($i = 1; $i < $count; $i++) {
            $f = $i === 1 ? '' . $filename[$i] : $f . $filename[$i];
        }
        return $f;
    }

    public static function get_date($date) {
        $date = new DateTime($date);
        $now = new DateTime();
        return $date->format('Y') < $now->format('Y') ? $date->format('d M Y H:i') : $date->format('d M H:i');
    }

    public static function is_teacher($class) {
        global $userID;
        return $class['teacherID'] == $userID;
    }

    public static function has_param($param) {
        if(!isset($param) || !is_numeric($param) || $param < 1) {
            return false;
        }
        return true;
    }

    public static function get_array($array) {
        $array = isset($array) ? $array : [];
        $array = Utils::has_string_keys($array) ? [$array] : $array;
        return $array;
    }
}

?>
