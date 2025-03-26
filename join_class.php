<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

function get_clss() {
    $classID = $_GET['class'];
    $class = DB::select('*', 'classes', "ID = '$classID'");
    if(!$class || !is_array($class) || empty($class)) {
        header("Location: index.php");
    }
    return $class;
}

if(!Utils::has_param($_GET['class'])) {
    header("Location: index.php");
}

$class = get_clss();
$classID = $class['ID'];

//$isLogged = isset($_COOKIE['userID']);
$isLogged = false;
$isTeacher = false;
if($isLogged) {
    //$isTeacher = Utils::is_teacher($class);
    $students = json_decode($class['students'], true);
}

if($isTeacher) {
    $teacher = DB::select('*', 'users', "ID = '{$class['teacher']}'");
} else {
    $teacher = $user;
}


?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <?php if($isTeacher): ?>
    <div class="col gap-1r">
        <h2>Invite Students</h2>
    </div>
    <?php else: ?>
        <div class="col gap-1r">
            <h2>Do you want to join this class?</h2>
            <div class="row space-between al-c gap-1r">
               <p class="w-80 bubble bold black"><?php echo $class['name'] ?></p>
               <div class="row gap-05r al-c">
                   <p class="f-large"> <?= $teacher['name'] ?> </p>
                   <img src=<?= $teacher['image'] ?> alt="" class="profile-img" style="width: 32px; height: 32px;">
               </div>
            </div>

            <?php if($isLogged): ?>
                <form action="join_class.php" method="post">
                    <input type="hidden" name="class" value="<?php echo $classID; ?>">
                    <button type="submit" class="btn btn-primary">Join</button>
                </form>
            <?php else: ?>
                <p>You will need an account for that...</p>
                <div class="row gap-1r">
                    <a class="w-100 bubble <?php echo rand_color(); ?> bold" href="index.php">Login</a>
                    <a class="w-100 bubble <?php echo rand_color(); ?> bold" href="index.php">Register</a>
                </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>


<?php include('comps/footer.php') ?>

<script type="module" src="public/js/modal.js"></script>
<script src="public/js/file_upload.js"></script>
