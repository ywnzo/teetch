<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

function assign_level_set($classID) {
    if(!isset($_POST['level_set']) || !isset($_POST['level'])) {
        header("Location: ?class={$classID}");
        return;
    }
    $setID = htmlspecialchars($_POST['level_set']);
    $levelID = htmlspecialchars($_POST['level']);

    $setOrder = DB::select('setOrder', 'levels', "ID = '$levelID'")['setOrder'];
    DB::update('classes', "currentLevel = '$setOrder', currentLevelSet = '$setID'", "ID = '$classID'");
    DB::delete('levelRequirementsStatus', "classID = '$classID' AND ownerID = '{$_COOKIE['userID']}'");
    header("Location: ?class={$classID}");
}

function is_completed($reqsStatus, $id) {
    foreach($reqsStatus as $status) {
        if($status['reqID'] === $id) {
            return true;
        }
    }
    return false;
}

function parse_reqs($classID, $currentLevelID) {
    $reqs = Utils::get_array(DB::select('*', 'levelRequirements', "levelID = {$currentLevelID}"));
    $reqsStatus = Utils::get_array(DB::select('*', 'levelRequirementsStatus', "classID = '$classID' AND levelID = {$currentLevelID}"));
    $level = [];

    foreach($reqs as $req) {
        $reqID = $req['ID'];
        $level['reqs'][$reqID] = $req;
        $level['reqs'][$reqID]['status'] = is_completed($reqsStatus, $reqID) ? 1 : 0;
    }

    if(!isset($level['reqs'])) {
        $level['reqs'] = [];
    }

    return $level;
}

function save_level($classID, $level, $reqs) {
    global $conn;
    $setID = $level['setID'];
    $levelID = $level['ID'];
    $isCompleted = count($reqs) === count($_POST) - 1 ? true : false;

    foreach($reqs as $reqID => $req) {
        $status = array_key_exists($reqID, $_POST) ? 1 : 0;
        if($status === 1) {
            DB::update('levelRequirementsStatus', "status = '$status'", "reqID = '$reqID'");
            $sql = "INSERT INTO levelRequirementsStatus (ownerID, classID, levelID, reqID, status)
                SELECT '{$_COOKIE['userID']}', '$classID', '$levelID', '$reqID', '$status'
                WHERE NOT EXISTS (SELECT 1 FROM levelRequirementsStatus WHERE reqID = '$reqID')";
            mysqli_query($conn, $sql);
        } else {
            DB::delete('levelRequirementsStatus', "reqID = '$reqID' AND ownerID = '{$_COOKIE['userID']}'");
        }
    }

    if($isCompleted) {
        $levelCount = DB::select('COUNT(ID) as count', 'levels', "setID = '$setID'")['count'];
        if($level['setOrder'] + 1 <= $levelCount) {
            DB::update('classes', "currentLevel = currentLevel + 1", "ID = '$classID' AND currentLevelSet = '$setID' AND teacherID = '{$_COOKIE['userID']}'");
            DB::delete('levelRequirementsStatus', "levelID = '$levelID' AND ownerID = '{$_COOKIE['userID']}'");
        }
    }

    header("Location: ?class={$classID}");
}

if(!isset($_GET['class'])) {
    header('Location: index.php');
}

$classID = htmlspecialchars($_GET['class']);
$class = DB::select('*', 'classes', "ID = $classID");
$isTeacher = $class['teacherID'] != $userID ? false : true;

if(isset($_POST['select_level_set'])) {
    $existingReqs = DB::select('COUNT(ID) as count', 'levelRequirementsStatus', "classID = '$classID' LIMIT 1");
    $count = (int)$existingReqs['count'];
    if($count === 0) {
        assign_level_set($classID);
    }
}

$currentSetID = $class['currentLevelSet'];
$currentLevelSet = DB::select('*', 'levelSets', "ID = '$currentSetID'");
$currentLevelIndex = $class['currentLevel'];
$currentLevel = DB::select('*', 'levels', "setID = '$currentSetID' AND setOrder = '$currentLevelIndex'");
$hasLevels = isset($currentLevel);

if($hasLevels && !isset($_GET['changeSet'])) {
    $level = parse_reqs($classID, $currentLevel['ID']);
    $level['ID'] = $currentLevel['ID'];
    $level['name'] = $currentLevel['name'];

    if(isset($_POST['save_level']) && isset($level['reqs'])) {
        save_level($classID, $currentLevel, $level['reqs']);
    }
}

$levelSets = Utils::get_array(DB::select('*', 'levelSets', "ownerID = '$userID'"));

$backURL = "class.php?action=view&class={$class['ID']}";


?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <div class="col gap-1r">
        <?php if(!$hasLevels || isset($_GET['changeSet'])): ?>
            <div id="breadcrumb" class="row gap-05r al-c bold">
                <a class="clickable black" href="<?php echo $backURL?>"><?php echo  $class['name'] ?></a>
                /
                <p class="red"">Change Set</p>
            </div>

            <h2>Select Level Set</h2>
            <form method="POST" class="col gap-05r">
                <select name="level_set" id="level-set-select" class="clickable">
                    <option value="" disabled selected>Select a set</option>
                    <?php foreach($levelSets as $levelSet): ?>
                        <option value="<?php echo $levelSet['ID'] ?>"><?php echo $levelSet['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="level" id="level-select" style="display: none;">
                    <option value="" disabled selected>Select a level</option>
                </select>
                <button type="submit" name="select_level_set" class="bubble bold black ?> clickable">
                    Confirm
                </button>

                <div class="col gap-1r" style="margin-top: 2rem;">
                    <?php foreach($levelSets as $levelSet): ?>
                        <div class="set-level col gap-1r" id="<?php echo $levelSet['ID'] ?>" style="display: none;">
                            <h2 class=""><?php echo $levelSet['name'] ?></h2>
                            <div class="col gap-05r">
                                <?php $levels = Utils::get_array(DB::select('*', 'levels', "setID = '{$levelSet['ID']}'")); ?>
                                <?php foreach($levels as $level): ?>
                                    <?php $requirements = Utils::get_array(DB::select('*', 'levelRequirements', "levelID = '{$level['ID']}'")); ?>

                                    <div class="level-array col al-c" style="gap: 0.2rem;" id="<?php echo $level['ID'] ?>">
                                        <p class="w-100 bubble <?php echo rand_color(); ?> bold"><?php echo $level['name'] ?></p>
                                        <?php foreach($requirements as $requirement): ?>
                                            <div class="w-100 row space-between" style="box-sizing: border-box; padding: 0.5rem; <?php echo $requirement != end($requirements) ? 'border-bottom: 1px solid #ccc;' : ''; ?>">
                                                <p class="bold"><?php echo $requirement['name'] ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>

        <?php else: ?>

            <div id="breadcrumb" class="row gap-05r al-c bold">
                <a class="clickable black" href="<?php echo $backURL?>"><?php echo  $class['name'] ?></a>
                /
                <p class="red"">Class Levels</p>
            </div>

            <div class="row space-between al-c">
                <h2 class="class-level-title"><?php echo $currentLevelSet['name'] ?></h2>
                <a id="change-set-btn" href="?class=<?php echo $classID ?>&changeSet=true" class="bubble bold black horizontal">Change Set</a>
            </div>

            <?php if(!isset($level)): ?>
                <p>This set doesn't have any levels...</p>
                <a class="bubble bold black clickable" href="levels.php?set=<?php echo $setID ?>">Add Levels</a>
            <?php else: ?>

                <p class="w-100 bubble <?php echo rand_color(); ?> bold"><?php echo $level['name'] ?></p>

                <form method="POST" class="set-level col gap-05r"">
                    <div class="col al-c" style="gap: 0.2rem;">
                        <?php if(empty($level['reqs'])): ?>
                            <p class="bold">No requirements set for this level.</p>
                        <?php else: ?>
                            <?php foreach($level['reqs'] as $req): ?>
                                <div class="w-100 row space-between" style="box-sizing: border-box; padding: 0.5rem; <?php echo $req != end($level['reqs']) ? 'border-bottom: 1px solid #ccc;' : ''; ?>">
                                    <p class="bold"><?php echo $req['name'] ?></p>
                                    <label class="container horizontal">
                                        <input class="" type="checkbox" name="<?php echo $req['ID'] ?>"
                                            value="1"
                                            <?php echo $req['status'] === 1 ? ' checked' : ''; ?>
                                            <?php echo $isTeacher ? '' : 'disabled'; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if($isTeacher): ?>
                        <button name="save_level" class="bubble black bold clickable" style="margin-top: 2rem;">Save</button>
                    <?php endif; ?>
                </form>
            <?php endif; ?>

        <?php endif; ?>
    </div>


</div>


<?php include('comps/footer.php') ?>
