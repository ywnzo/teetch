<?php

function sort_classes($classes) {
    $classesSorted = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];
    foreach($classes as $class) {
        $times = json_decode($class['times'], true);
        foreach($times as $time) {
            if(!isset($time['day']) || !isset($time['start']) || !isset($time['end'])) { continue; }
            $day = $time['day'];
            $timeStart = $time['start'];
            $timeEnd = $time['end'];
            $class['time']['day'] = $day;
            $class['time']['start'] = $timeStart;
            $class['time']['end'] = $timeEnd;
            $classesSorted[$day][] = $class;
        }
    }

    foreach($classesSorted as $day => $classes) {
        ksort($classesSorted[$day]);
    }
    return $classesSorted;
}

$classes = Utils::get_array(DB::select('*', 'classes', "teacherID = '$userID' OR JSON_VALID(students) AND JSON_CONTAINS(students, '$userID')"));
$classesSorted = sort_classes($classes);
$days = array_keys($classesSorted);

?>
