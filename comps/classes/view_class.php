<?php

if(!Utils::has_param($_GET['class'])) {
    header("Location: index.php");
}

$classID = htmlspecialchars($_GET['class']);
$class = DB::select('*', 'classes', "ID = '$classID'");
$students = json_decode($class['students'], true);

if(!$class || !is_array($class) || empty($class)) {
    header("Location: index.php");
}

$isTeacher = Utils::is_teacher($class);
if(!$isTeacher) {
    if(!in_array($userID, $students)) { header("Location: index.php"); }
}

if(isset($_GET['delete'])) {
    DB::delete('classes', "ID = '$classID'");
    $updates = Utils::get_array(DB::select('file', 'classUpdates', "classID = '$classID'"));
    print_r($updates);

    foreach($updates as $update) {
        if(isset($update['file'])) {
            unlink(getcwd() . '/public/storage/uploads/' . $update['file']);
        }
    }

    DB::delete('classUpdates', "classID = '$classID'");
    DB::delete('levelRequirementsStatus', "classID = '$classID' AND ownerID = '{$_COOKIE['userID']}'");

    header("Location: index.php");
}

$times = json_decode($class['times'], true);
$canCreate = true;
$table = 'classUpdates';

$teacher = DB::select('*', 'users', "ID = '{$class['teacherID']}'");
if(!isset($teacher)) {
    header("Location: index.php");
}

?>

<div class="col gap-1r">
    <div class="row space-between al-c">
        <div id="breadcrumb" class="row gap-05r al-c bold">
            <p class="red"><?= $class['name'] ?></p>
        </div>
    </div>

    <div id="<?php echo count($times) <= 2 ? '' : 'classInfo' ?>" class="<?php echo count($times) <= 2 ? 'row' : 'col' ?> space-between">
        <div id="time-container">
            <?php foreach($times as $time): ?>
                <p class="time"><?= $time['day'] ?> <?= $time['start'] ?> - <?= $time['end'] ?></p>
            <?php endforeach; ?>
        </div>

        <a href="profile.php?user=<?= $class['teacherID'] ?>" class="row gap-05r al-c js-e bold horizontal">
            <p class="f-large">
                <?= $teacher['name'] ?>
            </p>
            <img src=<?= $teacher['image'] ?> alt="" class="profile-img" style="width: 32px; height: 32px;">
        </a>
    </div>

    <?php include('comps/chat.php'); ?>
</div>

<script type="module" src="public/js/modal.js"></script>
<script src="public/js/file_upload.js"></script>
