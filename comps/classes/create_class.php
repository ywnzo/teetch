<?php

function get_times() {
    $times = [];
    $index = 0;
    while (true) {
        if (!isset($_POST["time" . $index])) {
            break;
        }
        $time = explode(", ", $_POST["time" . $index]);
        $day = $time[0];
        $time = explode(" - ", $time[1]);
        $times[] = [
            "day" => $day,
            "start" => $time[0],
            "end" => $time[1],
        ];
        $index += 1;
    }
    return $times;
}

function create_class($userID) {
    $class_name = htmlspecialchars($_POST["class_name"]);
    $times = json_encode(get_times());
    DB::insert(
        "classes",
        "name, teacherID, link, students, times",
        "'$class_name', '$userID', '', '[]', '$times'"
    );

    global $conn;
    $sql = "SELECT LAST_INSERT_ID() as id";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);
    return $result['id'];
}

if (isset($_POST["create-class"])) {
    $classID = create_class($userID);
}

$day = isset($_GET["day"]) ? $_GET["day"] : date("D");
$levels = Utils::get_array(DB::select("*", "levelSets", "ownerID = '$userID'"));
?>

<div class="col gap-1r" style="margin-bottom: 2rem;">
    <h2>Create a new class</h2>
    <form method="POST" class="col space-between gap-05r">
        <input type="text" name="class_name" placeholder="Enter class Name" class="w-100 red" required>

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

        <div id="time-container"></div>
        <button name="create-class" class="bubble <?php echo rand_color(); ?> clickable"><i class="fa-solid fa-plus"></i></button>

    </form>
</div>

<script src="public/js/create_class.js"></script>
