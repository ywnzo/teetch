<?php

function sort_classes($classes) {
    $clss = ['Mon' => [], 'Tue' => [], 'Wed' => [], 'Thu' => [], 'Fri' => [], 'Sat' => [], 'Sun' => []];
    foreach($classes as $class) {
        $times = json_decode($class['times'], true);
        if(!isset($times) || !is_array($times)) { continue; }
        foreach($times as $time) {
            if(!isset($time['day']) || !isset($time['start']) || !isset($time['end'])) { continue; }
            $day = $time['day'];
            $timeStart = $time['start'];
            $timeEnd = $time['end'];
            $class['time']['day'] = $day;
            $class['time']['start'] = $timeStart;
            $class['time']['end'] = $timeEnd;
            $clss[$day][$timeStart] = $class;
        }
    }

    foreach($clss as $day => $classes) {
        ksort($clss[$day]);
    }
    return $clss;
}

$classes = DB::select('*', 'classes', "teacherID = '$userID'");
$classes = !isset($classes) || !is_array($classes) || empty($classes) ? [] : $classes;
$classes = Utils::has_string_keys($classes) ? [$classes] : $classes;
$classesSorted = sort_classes($classes);
$days = array_keys($classesSorted);

?>
