<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

function create_lesson_plan() {
    if(!isset($_GET['class'])) {
        echo "Missing classID";
        return;
    }
    if(!isset($_POST['class_name'])) {
        echo "Missing class_name";
        return;
    }
    if(!isset($_POST['date'])) {
        echo "Missing date";
        return;
    }
    if(!isset($_POST['time'])) {
        echo "Missing time";
        return;
    }

    $classID = $_GET['class'];
    $name = $_POST['class_name'];
    $date = $_POST['date'] . ' ' . $_POST['time'];
    DB::insert('lessons', 'classID, name, date', "'$classID', '$name', '$date'");
    header('Location: lessons.php?class=' . $classID);
}



if(!isset($_GET['class'])) { header('Location: index.php'); }
$classID = $_GET['class'];
$class = DB::select('*', 'classes', "ID = '$classID'");
$times = json_decode($class['times'], true);

$lessons = Utils::get_array( DB::select('*', 'lessons', "classID = '$classID' ORDER BY date DESC"));

$backURL = "class.php?action=view&class={$class['ID']}";

if(!$class['teacherID'] == $userID) { header('Location: index.php'); }

if(isset($_POST['add_lesson_plan'])) { create_lesson_plan(); }
?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <div class="col gap-1r">
        <div id="breadcrumb" class="row gap-05r al-c bold">
            <a class="clickable black" href="<?php echo $backURL?>"><?php echo  $class['name'] ?></a>
            /
            <p class="red"">Lessons</p>
        </div>

        <div class="col gap-1r">
            <h2>Insert a lesson plan</h2>
            <form method="POST" class="col space-between gap-05r">
                <input type="text" name="class_name" placeholder="Enter lesson plan name..." class="w-100 red" required>

                <div class="row al-c space-between">
                    <div class="row al-c gap-05r">
                        <input type="date" name="date" id="date" class="clickable" required>
                        <select name="time" id="time" class="clickable" required>
                            <?php foreach($times as $time): ?>
                                <option value="<?php echo $time['start'] ?>" selected > <?php echo $time['start'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" name="add_lesson_plan" class="bubble <?php echo rand_color() ?> horizontal"><i class="fa-solid fa-plus"></i></button>
                </div>
            </form>
        </div>

        <div class="col gap-1r" style="margin-top: 1rem;">
            <h2>Your lesson plans</h2>
            <div class="col" style="gap: 0.2rem;">
                <?php foreach($lessons as $lesson): ?>
                    <a href="lesson_plan.php?class=<?php echo $lesson['classID'] ?>&lesson=<?php echo $lesson['ID'] ?>" class="bubble bold <?php echo rand_color() ?> horizontal">
                        <div class="w-100 row space-between">
                            <p><?php echo $lesson['name'] ?></p>
                            <div class="row gap-1r">
                                <p><?php echo Utils::get_date($lesson['date']) ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</div>

<?php include('comps/footer.php') ?>
