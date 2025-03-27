<?php

if(isset($_POST['add_requirement'])) {
    $levelID = htmlspecialchars($_POST['levelID']);
    $requirementName = htmlspecialchars($_POST['requirementName']);
    DB::insert('levelRequirements', "ownerID, levelID, name", "'$userID', '$levelID', '$requirementName'");
}

if(isset($_GET['action']) && $_GET['action'] == 'deleteLevel') {
    $levelID = htmlspecialchars($_GET['id']);
    DB::delete('levels', "ID = '$levelID' AND ownerID = '$userID'");
    DB::delete('levelRequirements', "levelID = '$levelID' AND ownerID = '$userID'");
    DB::delete('levelRequirementsStatus', "levelID = '$levelID' AND ownerID = '$userID'");
    header('Location: levels.php?set=' . $setID);
}

if(isset($_POST['moveDown'])) {
    $moveID = htmlspecialchars($_POST['moveDown']);
    $levelToMove = DB::select('setOrder', 'levels', "ID = '$moveID'");
    $offset = $levelToMove['setOrder'] + 1;

    DB::update('levels', 'setOrder = setOrder - 1', "setOrder = '$offset'");
    DB::update('levels', 'setOrder = setOrder + 1', "ID = '$moveID'");
    header('Location: levels.php?set=' . $setID);
}

if(isset($_POST['moveUp'])) {
    $moveID = htmlspecialchars($_POST['moveUp']);
    $levelToMove = DB::select('setOrder', 'levels', "ID = '$moveID'");
    $offset = $levelToMove['setOrder'] - 1;

    DB::update('levels', 'setOrder = setOrder + 1', "setOrder = '$offset'");
    DB::update('levels', 'setOrder = setOrder - 1', "ID = '$moveID'");
    header('Location: levels.php?set=' . $setID);
}

?>

<div class="row space-between">
    <input id="set-name-input" setID="<?php echo $setID ?>" class="set-name-input" type="text" value="<?php echo $set['name'] ?>">
    <a href="?set=<?php echo $setID ?>&action=deleteSet&id=<?php echo $setID ?>" class="bubble red horizontal"><i class="fa-solid fa-trash"></i></a>
</div>

<!-- <h2>Add a new level</h2> -->
<form method="POST" action="" class="col gap-05r">
    <input type="text" id="levelName" name="levelName" placeholder="Enter level name" required>
    <button class="bubble bold clickable <?php echo rand_color() ?>" name="add_level" type="submit">Add Level</button>
</form>

<h2>Your Levels</h2>
<div class="col" style="gap: 0.2rem">
    <?php if(empty($levels)): ?>
        <p class="bubble black bold">This level set has no levels.</p>
    <?php else: ?>
        <?php foreach($levels as $level): ?>
            <div class="col">
                <div class="row gap-05r al-c">
                    <div class="w-100 col">
                        <button id="lvl-btn-<?php echo $level['ID'] ?>" class="w-100 lvl-btn bubble <?php echo rand_color() ?> bold horizontal" style="justify-content: start;" mode="start">
                            <?php echo $level['name'] ?>
                        </button>
                        <input type="text" id="lvl-input-<?php echo $level['ID'] ?>" value="<?php echo $level['name'] ?>" style="display: none;">
                    </div>

                    <div class="row" style="gap: 0.2rem">
                        <button id="<?php echo $level['ID'] ?>" class="edit-btn bubble clickable black bold"><i class="fa-solid fa-pen-to-square"></i></button>
                        <a href="?set=<?php echo $setID ?>&action=deleteLevel&id=<?php echo $level['ID'] ?>" class="bubble red horizontal"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>

                <div id="req-container-<?php echo $level['ID'] ?>" class="level-req-container ">
                    <form method="POST" class="w-100 row gap-05r">
                        <form method="POST">
                            <?php if($level != end($levels)): ?>
                                <input type="hidden" name="">
                                <button class="w-100 bubble black bold clickable" name="moveDown" value="<?php echo $level['ID'] ?>"><i class="fa-solid fa-down-long"></i></button>
                            <?php endif; ?>
                            <?php if($level != reset($levels)): ?>
                                <button class="w-100 bubble black bold clickable" name="moveUp" value="<?php echo $level['ID'] ?>"><i class="fa-solid fa-up-long"></i></button>
                            <?php endif; ?>
                    </form>

                    <h4>Level requirements</h4>
                    <?php $requirements = Utils::get_array(DB::select('*', 'levelRequirements', "levelID = {$level['ID']}") )?>
                    <div class="col" style="margin-bottom: 1rem; gap: 0.2rem">
                        <?php if(empty($requirements)): ?>
                            <p class="bubble black bold">This level has no requirements.</p>
                        <?php else: ?>
                            <?php foreach($requirements as $requirement): ?>
                                <div class="col gap-05r">
                                    <input id="<?php echo $requirement['ID'] ?>" type="text" class="req-name-input" value="<?= $requirement['name'] ?>"> </input>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button id="add-req-<?= $level['ID'] ?>" class="add-req-btn bubble bold clickable <?php echo rand_color() ?>" name="add_requirement" type="submit">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div id="add-req-form-<?= $level['ID'] ?>" class="add-req-form">
                        <h4>Add a requirement</h4>
                        <form action="" method="POST" class="col gap-05r">
                            <input type="hidden" name="levelID" value="<?php echo $level['ID'] ?>">
                            <input type="text" id="levelName" name="requirementName" placeholder="Enter a requirement name" required>
                            <button class=" bubble bold clickable <?php echo rand_color() ?>" name="add_requirement" type="submit">
                                Add a requirement
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script type="module" src="public/js/cookies.js"></script>
<script type="module" src="public/js/level_requirements.js"></script>
