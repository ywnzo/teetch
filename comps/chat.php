<?php

$error = '';


function get_updates_class() {
    global $classID, $userID, $resultCount, $offset;
    $updates = Utils::get_array(DB::select('*',
    'classUpdates',
    "classID = $classID AND ownerID = '$userID'
        ORDER BY ID DESC LIMIT $resultCount OFFSET $offset"));
    return $updates;
}

function get_updates_lesson() {
    global $classID, $lessonID, $userID, $resultCount, $offset;
    $updates = Utils::get_array(DB::select('*',
    'lessonUpdates',
    "classID = $classID AND lessonID = $lessonID AND ownerID = '$userID'
        ORDER BY ID DESC LIMIT $resultCount OFFSET $offset"));
    return $updates;
}

function create_update($classID, $lessonID, $userID, $table) {
    if(isset($_POST['update-text']) && !empty($_POST['update-text'])) {
        $text = $_POST['update-text'];
        if(isset($lessonID)) {
            DB::insert($table, 'classID, lessonID, ownerID, text', "'$classID', '$lessonID', '$userID', '$text'");
        } else {
            DB::insert($table, 'classID, ownerID, text', "'$classID', '$userID', '$text'");
        }
    } else {
        $error = 'No text provided';
    }
}

if(isset($_POST['update-submit'])) {
    $lessonID = isset($lessonID) ? $lessonID : null;
    create_update($classID, $lessonID, $userID, $table);
}

$file_path = 'public/storage/uploads/';
$imgExts = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'GIF'];

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$resultCount = isset($_GET['count']) ? (int)$_GET['count'] : 15;

if($table === 'lessonUpdates') {
    $updates = get_updates_lesson();
    $updateCount = DB::select('COUNT(ID) AS count', 'lessonUpdates', "classID = $classID AND lessonID = $lessonID AND ownerID = '$userID'");
} else {
    $updates = get_updates_class();
    $updateCount = DB::select('COUNT(ID) AS count', 'classUpdates', "classID = $classID AND ownerID = '$userID'");
}

$canInvite = false;

?>


<div class="chat col gap-2r">
    <?php if($canCreate): ?>
        <form method="POST" class="col gap-1r">
            <div class="col space-between gap-05r">
                <div class="row space-between">
                    <?php if($isTeacher): ?>
                        <div class="row gap-05r al-c">
                            <button type="button" cat="text" class="add-btn bubble bold clickable <?php echo rand_color()?>">
                                <i class="fa-solid fa-font"></i>
                            </button>
                            <button type="button" cat="file" class="add-btn bubble bold clickable <?php echo rand_color()?>">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </button>
                        </div>

                        <div class="row gap-05r al-c">
                            <?php if($table !== "lessonUpdates"): ?>
                                <a href="lessons.php?class=<?= $classID ?>" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </a>
                            <?php endif; ?>

                            <?php if($canInvite): ?>
                                <button type="button" id="add_student_button" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-user-plus"></i>
                                </button>
                            <?php endif; ?>

                            <?php if($table != 'lessonUpdates'): ?>
                                <a href="class_levels.php?class=<?= $classID ?>" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-stairs"></i>
                                </a>
                                <a href="class.php?class=<?= $classID ?>&action=edit" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                                <a href="class.php?action=view&class=<?= $classID ?>&delete=true" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            <?php else: ?>
                                <a href="lesson_plan.php?class=<?= $classID ?>&lesson=<?php echo $lessonID ?>&action=edit" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                                <a href="lesson_plan.php?class=<?= $classID ?>&lesson=<?php echo $lessonID ?>&delete=true" class="bubble bold clickable <?php echo rand_color()?>">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            <?php endif; ?>



                        </div>
                    <?php endif; ?>
                </div>

                <div class="add-wrapper w-100" cat="text">
                    <textarea class="w-100" name="update-text" id="update-text" rows="4" placeholder="Enter text..."></textarea>
                </div>

                <div class="add-wrapper w-100 col" id="file-wrapper" cat="file" style="display: none;" ondrop="upload_file(event)" ondragover="return false">
                    <p>Drop file(s) here</p>
                    <p>or</p>
                    <input type="button" class="bubble bold clickable black" value="Select File(s)" onclick="file_explorer();" />
                    <input type="file" id="select-file" multiple />
                </div>

                <button type="submit" name="update-submit" class="bubble bold clickable <?php echo rand_color()?>" style="min-width: 100%;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <p><?= $error ?></p>
        </form>
    <?php endif; ?>

    <div class="col gap-1r">
        <div id="update-container" class="col gap-1r">
            <?php if(empty($updates)): ?>
                <p class="bubble black bold">Nothing here yet...</p>
            <?php else: ?>
                <?php foreach($updates as $update) {
                    if(isset($update['file'])) {
                        $file = $update['file'];
                        include('comps/updates/update_file.php');
                    } elseif(isset($update['text'])) {
                        include('comps/updates/update_text.php');
                    }
                } ?>
            <?php endif; ?>
        </div>
    </div>

    <!--
    <?php if($updateCount['count'] >= 15): ?>
        <div class="page-btn-container row gap-05r bold">
            <?php for($i = 0; $i < $updateCount['count'] / $resultCount; $i++): ?>
                <?php if($table === 'lessonUpdates'): ?>
                    <a href="lesson_plan.php?class=<?= $classID ?>&lesson=<?= $lessonID ?>&offset=<?= $i ?>" class="bubble clickable <?= $i == $offset ? 'red' : 'black' ?>">
                        <?= $i + 1?>
                    </a>
                <?php else: ?>
                    <a href="class.php?action=view&class=<?= $classID ?>&offset=<?= $i ?>" class="bubble clickable <?= $i == $offset ? 'red' : 'black' ?>">
                        <?= $i + 1?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    -->
</div>
