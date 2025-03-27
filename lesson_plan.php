<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

function update_lesson_plan($lessonID) {
    $userID = htmlspecialchars($_COOKIE['userID']);
    $name = htmlspecialchars($_POST['lesson_name']);
    $date = htmlspecialchars($_POST['date']) . ' ' . htmlspecialchars($_POST['time']);
    DB::update('lessons', "name = '$name', date = '$date'", "ID = '$lessonID' AND teacherID = '$userID'");
}

function get_lesson() {
    $lessonID = htmlspecialchars($_GET['lesson']);
    $lesson = DB::select('*', 'lessons', "ID = '$lessonID'");
    if(!$lesson || !is_array($lesson) || empty($lesson)) {
        header("Location: index.php");
    }
    return $lesson;
}

function get_clss() {
    $classID = htmlspecialchars($_GET['class']);
    $class = DB::select('*', 'classes', "ID = '$classID'");
    if(!$class || !is_array($class) || empty($class)) {
        header("Location: index.php");
    }
    return $class;

}

if(!Utils::has_param($_GET['lesson'])) {
    header("Location: index.php");
}

if(isset($_POST['edit_lesson_plan'])) {
    update_lesson_plan($_GET['lesson']);
}

$lesson = get_lesson();
$lessonID = $lesson['ID'];
$class = get_clss();
$classID = $class['ID'];

if(isset($_GET['delete'])) {
    DB::delete('lessons', "ID = '$lessonID' AND teacherID = '{$_COOKIE['userID']}'");
    DB::delete('lessonUpdates', "lessonID = '$lessonID' AND ownerID = '{$_COOKIE['userID']}'");
    header("Location: lessons.php?class={$class['ID']}");
}

$isTeacher = Utils::is_teacher($class);
$canCreate = true;
$table = 'lessonUpdates';

$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$times = json_decode($class['times'], true);

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <?php if($action == 'view'): ?>
        <div class="col gap-1r">
            <div class="row space-between al-c">
                <div id="breadcrumb" class="row gap-05r al-c bold">
                    <a class="black clickable" href="class.php?action=view&class=<?php echo $class['ID'] ?>"><?php echo $class['name'] ?></a>
                    /
                    <a class="black clickable" href="lessons.php?class=<?php echo $class['ID'] ?>">Lessons</a>
                    /
                    <p class="red""><?php echo $lesson['name'] ?></p>
                </div>
            </div>

            <?php include('comps/chat.php'); ?>
        </div>
    <?php elseif($action == 'edit'): ?>
        <div class="col gap-1r">
            <div class="col gap-1r">
                <div id="breadcrumb" class="row gap-05r al-c bold">
                    <a class="black clickable" href="class.php?action=view&class=<?php echo $class['ID'] ?>"><?php echo $class['name'] ?></a>
                    /
                    <a class="black clickable" href="lessons.php?class=<?php echo $class['ID'] ?>">Lessons</a>
                    /
                    <a class="black"" href="?class=<?php echo $class['ID'] ?>&lesson=<?php echo $lesson['ID'] ?>&action=view"><?php echo $lesson['name'] ?></a>
                    /
                    <p class="red"">Edit Lesson</p>
                </div>

                <form method="POST" class="col gap-05r">
                    <input type="text" name="lesson_name" placeholder="Enter lesson plan name..." value="<?php echo $lesson['name'] ?>" required>
                    <div class="row al-c space-between">
                        <div class="row al-c gap-05r">
                            <input type="date" name="date" id="date" class="clickable" value="<?php echo date('Y-m-d', strtotime($lesson['date'])) ?>" required>
                            <select name="time" id="time" class="clickable" required>
                                <?php foreach($times as $time): ?>
                                    <option value="<?php echo $time['start'] ?>" selected > <?php echo $time['start'] ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>
                    <button type="submit" name="edit_lesson_plan" class="w-100 bubble <?php echo rand_color() ?> clickable">
                        <i class="fa-solid fa-check"></i>
                    </button>

                </form>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php include('comps/footer.php') ?>

<script type="module" src="public/js/modal.js"></script>
<script src="public/js/file_upload.js"></script>
