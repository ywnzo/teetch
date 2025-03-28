<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(!isset($_GET['user'])) {
    header('Location: index.php');
}

$profileUserID = htmlspecialchars($_GET['user']);
$profileUser = null;

if($profileUserID != $userID) {
    $profileUser = DB::select('*', 'users', "ID = '$profileUserID'");
    $canEdit = false;
} else {
    $profileUser = $user;
    $canEdit = true;
}

if($profileUser === null) {
    header('Location: index.php');
}

$classes = DB::select('*', 'classes', "teacherID = '$profileUserID' OR JSON_VALID('students') AND JSON_CONTAINS(students, '$userID')");
include('comps/classes/sort_classes.php');

$dateJoined = new DateTime($profileUser['createdAt']);
$dateJoined = $dateJoined->format('d. M Y');


?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <div class="row gap-05r space-between box-sizing: border-box;">
        <img src=<?= $profileUser['image'] ?> alt="" style="max-width: 320px; max-height: 320px; border-radius: 50%; object-fit: cover; aspect-ratio: 1; border: 2px solid var(--black);">
        <div class="col al-s js-c gap-1r" style="width: 40%; box-sizing: border-box;">
            <h1><?= $profileUser['name'] ?></h1>
            <p><b><?= $profileUser['role'] ?></b></p>
            <a href="mailto:<?= $profileUser['email'] ?>" class="horizontal">
                <?= $profileUser['email'] ?>
            </a>
            <div class="col al-s">
                <p class="bold">Joined</p>
                <p><?= $dateJoined ?></p>
            </div>
        </div>
    </div>

    <div class="row" style="border-top: 2px solid lightgray; margin-top: 2rem; margin-bottom: 2rem;"></div>

    <div class="col al-s gap-1r" style="margin-top: 1rem;">
        <h2>Classes</h2>
        <div class="w-100 col gap-05r">
            <?php include('comps/classes/class_list.php') ?>
        </div>
    </div>

</div>


<?php include('comps/footer.php') ?>
