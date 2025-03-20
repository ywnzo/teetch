<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(!Utils::has_param($_GET['lesson'])) {
    header("Location: index.php");
}
$lessonID = $_GET['lesson'];
$lesson = DB::select('*', 'lessons', "ID = '$lessonID'");
if(!$lesson || !is_array($lesson) || empty($lesson)) {
    header("Location: index.php");
}

$classID = $_GET['class'];
$class = DB::select('*', 'classes', "ID = '$classID'");
if(!$class || !is_array($class) || empty($class)) {
    header("Location: index.php");
}

$backURL = "lessons.php?class={$classID}";

if(isset($_GET['delete'])) {
    DB::delete('lessons', "ID = '$lessonID'");
    header("Location: {$backURL}");
}

$isTeacher = Utils::is_teacher($class);
$canCreate = true;
$table = 'lessonUpdates';


?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <div class="col gap-1r">
        <div class="row space-between al-c">
            <div id="breadcrumb" class="row gap-05r al-c bold">
                <a class="black clickable" href="class.php?action=view&class=<?php echo $class['ID'] ?>"><?php echo $class['name'] ?></a>
                /
                <a class="black clickable" href="<?php echo $backURL?> ">Lessons</a>
                /
                <p class="red""><?php echo $lesson['name'] ?></p>
            </div>
        </div>

        <?php include('comps/chat.php'); ?>
    </div>
</div>


<?php include('comps/footer.php') ?>

<script type="module" src="public/js/modal.js"></script>
<script src="public/js/file_upload.js"></script>
