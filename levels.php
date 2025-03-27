<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

include('classes/levels.php');

if($user['role'] != 'Teacher') {
    header('Location: index.php');
}

if(isset($_POST['add_level_set'])) {
    $name = htmlspecialchars($_POST['name']);
    $ownerID = $userID;
    DB::insert('levelSets', "name, ownerID", "'$name', '$userID'");
}

if(isset($_POST['add_level'])) {
    $name = htmlspecialchars($_POST['levelName']);
    $levelSetID = htmlspecialchars($_GET['set']);
    $setOrder = DB::select('MAX(setOrder) as maxOrder', 'levels', "setID = '$levelSetID'")['maxOrder'] + 1;
    DB::insert('levels', "name, ownerID, setID, setOrder", "'$name', '$userID', '$levelSetID', '$setOrder'");
}

if(isset($_GET['action']) && $_GET['action'] == 'deleteSet') {
    $setID = htmlspecialchars($_GET['set']);
    $levelID = DB::select('ID', 'levels', "setID = '$setID'");
    print_r($levelID);

    DB::delete('levelSets', "ID = '$setID' AND ownerID = '$userID'");
    DB::delete('levels', "setID = '$setID'");
    foreach($levelID as $id) {
        if(!is_int($id)) {
            continue;
        }
        DB::delete('levelRequirements', "levelID = '$id' AND ownerID = '$userID'");
        DB::delete('levelRequirementsStatus', "levelID = '$id' AND ownerID = '$userID'");
    }
}

$levelSets = Utils::get_array(DB::select('*', 'levelSets', "ownerID = '$userID'"));

if(isset($_GET['set'])) {
    $setID = htmlspecialchars($_GET['set']);
    $set = DB::select('*', 'levelSets', "ID = '$setID' AND ownerID = '$userID'");
    if(!isset($set) or empty($set) or !($set)) {
        header('Location: levels.php');
    }
    $levels = Utils::get_array(DB::select('*', 'levels', "setID = '$setID' AND ownerID = '$userID' ORDER BY setOrder"));

    if(isset($_GET['level'])) {
        $levelID = htmlspecialchars($_GET['level']);
        $level = DB::select('*', 'levels', "ID = '$levelID' AND ownerID = '$userID'");
    }
}

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <div class="col gap-1r">
        <?php if(!isset($_GET['set'])): ?>
            <?php include('comps/levels/level_sets.php') ?>
        <?php else: ?>
            <?php include('comps/levels/levels.php') ?>
        <?php endif; ?>
    </div>


</div>


<?php include('comps/footer.php') ?>
