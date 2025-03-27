<?php

$mssg = "";

function get_times() {
    $times = [];
    $index = 0;
    while (true) {
        if (!isset($_POST["time" . $index])) {
            break;
        }
        $time = explode(", ", $_POST["time" . $index]);
        $day = htmlspecialchars($time[0]);
        $time = explode(" - ", $time[1]);
        $times[] = [
            "day" => $day,
            "start" => htmlspecialchars($time[0]),
            "end" => htmlspecialchars($time[1]),
        ];
        $index += 1;
    }
    return $times;
}

function update_class() {
    $classID = htmlspecialchars($_GET['class']);
    $class = DB::select('*', 'classes', "ID = '$classID'");
    $students = $class['students'];
    $userID = htmlspecialchars($_COOKIE['userID']);
    $class_name = htmlspecialchars($_POST["class_name"]);
    $times = json_encode(get_times());
    DB::update(
        "classes",
        "name = '$class_name', teacherID = '$userID', link = '', students = '$students', times = '$times'",
        "ID = '{$_GET['class']}' AND teacherID = '$userID'"
    );
}

if(!isset($_GET['class'])) {
    header('Location: index.php');
}

if (isset($_POST["update-class"])) {
    update_class();
    $mssg = "Class updated successfully!";
}

$day = isset($_GET["day"]) ? $_GET["day"] : date("D");
$class = DB::select('*', 'classes', "ID = '{$_GET['class']}'");

if(!isset($class)) {
    header('Location: index.php');
}



$times = json_decode($class['times'], true);
$timeIndex = 0;

?>

<div class="col gap-1r" style="margin-bottom: 2rem;">
    <div id="breadcrumb" class="row gap-05r al-c bold">
        <a href="class.php?class=<?= $class['ID'] ?>&action=view" class="black clickable"><?= $class['name'] ?></a>
        /
        <p class="red">Edit Class</p>
    </div>

    <h2>Edit class</h2>
    <form method="POST" class="col space-between gap-1r">
        <div class="col gap-05r">
            <input type="text" name="class_name" placeholder="Enter class Name" value="<?php echo $class['name']; ?>" class="w-100 red" required>

            <div class="row al-c space-between">
                <div class="row al-c gap-05r">
                    <select name="day" id="day" class="clickable" required>
                        <option value="Mon" <?php echo $day == "Mon"
                            ? "selected"
                            : ""; ?> >Mon</option>
                        <option value="Tue" <?php echo $day == "Tue"
                            ? "selected"
                            : ""; ?> >Tue</option>
                        <option value="Wed" <?php echo $day == "Wed"
                            ? "selected"
                            : ""; ?> >Wed</option>
                        <option value="Thu" <?php echo $day == "Thu"
                            ? "selected"
                            : ""; ?> >Thu</option>
                        <option value="Fri" <?php echo $day == "Fri"
                            ? "selected"
                            : ""; ?> >Fri</option>
                        <option value="Sat" <?php echo $day == "Sat"
                            ? "selected"
                            : ""; ?> >Sat</option>
                        <option value="Sun" <?php echo $day == "Sun"
                            ? "selected"
                            : ""; ?> >Sun</option>
                    </select>

                    <input type="time" id="time-start" name="time-start" class="clickable" value="00:00" required />
                    <input type="time" id="time-end" name="time-end" class="clickable" value="00:00" required />

                    <p class="bubble black clickable bold" id="add-time-btn"><i class="fa-solid fa-plus"></i> <i class="fa-solid fa-clock"></i></p>
                </div>
            </div>
        </div>


        <div id="time-container">
            <?php foreach($times as $time): ?>
                <div class="time clickable" onClick="on_time_click(event)">
                    <?php echo $time['day'] . ', ' . $time['start'] . ' - ' . $time['end']; ?>
                    <input type="hidden" name="time<?php echo $timeIndex++ ?>" value="<?php echo $time['day'] . ', ' . $time['start'] . ' - ' . $time['end']; ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button name="update-class" class="bubble <?php echo rand_color(); ?> clickable"><i class="fa-solid fa-check"></i></i></button>
    </form>

    <p><?php echo $mssg ?></p>
</div>

<script src="public/js/create_class.js"></script>
