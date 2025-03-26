<?php

function get_teacher_name($id) {
    $teacher = DB::select('*','users', "ID = '$id'");
    return $teacher['name'];
}

function get_student_count($class) {
    $students = json_decode($class['students'], true);
    return count($students);
}

if(!isset($classes)) {
    $classes = [];
} else {
    if(!empty($classes)) {
        if(Utils::has_string_keys($classes)) {
            $classes = [$classes];
        }
    }
}

include('comps/classes/sort_classes.php');

?>

<div class="col gap-1r">
    <div class="row space-between">
        <h2>Your Classes</h2>
    </div>
    <div class="col gap-2r">
        <?php include('comps/classes/class_list.php'); ?>
    </div>

</div>
