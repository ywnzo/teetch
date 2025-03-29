<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

function get_clss() {
    $classID = htmlspecialchars($_GET['class']);
    $class = DB::select('*', 'classes', "ID = '$classID'");
    if(!$class || !is_array($class) || empty($class)) {
        header("Location: index.php");
    }
    return $class;
}

function insert_join_request($class, $students) {
    echo "Inserting join request";
    $classID = htmlspecialchars($_GET['class']);
    $userID = htmlspecialchars($_COOKIE['userID']);
    $message = htmlspecialchars($_POST['message']);
    $students[] = $userID;
    $students = json_encode($students);
    DB::insert('joinRequests', 'classID, userID, message', "'$classID', '$userID', '$message'");
    header('Location: ?class=' . $classID);
}

function approve_join_request($requestID) {
    $request = DB::select('*', 'joinRequests', "ID = '$requestID'");
    $classID = $request['classID'];
    $userID = $request['userID'];
    $class = DB::select('*', 'classes', "ID = '$classID'");
    if($_COOKIE['userID'] != $class['teacherID']) {
        echo "You are not authorized to approve this request.";
        return;
    }

    $students = json_decode($class['students'], true);
    $students[] = $userID;
    $students = json_encode($students);
    DB::update('classes', "students = '$students'", "ID = '$classID'");
    DB::delete('joinRequests', "ID = '$requestID'");
}

function deny_join_request($requestID) {
    $request = DB::select('*', 'joinRequests', "ID = '$requestID'");
    $classID = $request['classID'];
    $class = DB::select('*', 'classes', "ID = '$classID'");
    if($_COOKIE['userID'] != $class['teacherID']) {
        return;
    }
    DB::delete('joinRequests', "ID = '$requestID'");
}

function send_join_invite($class) {
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
}

if(!Utils::has_param($_GET['class'])) {
    header("Location: index.php");
}

$class = get_clss();
$classID = $class['ID'];

$isLogged = isset($_COOKIE['userID']);
//$isLogged = true;
$isTeacher = false;
if($isLogged) {
    $isTeacher = Utils::is_teacher($class);
    $students = json_decode($class['students'], true);
    if(in_array($userID, $students)) {
        header("Location: class.php?action=view&class=$classID");
    }

    $joinRequest = DB::select('*', 'joinRequests', "classID = '$classID' AND userID = '$userID'");
    $waitingForApproval = isset($joinRequest);

    if(!$waitingForApproval) {
        if(isset($_POST['join_class'])) {
            insert_join_request($class, $students);
        }
    }
}

$teacher = $isTeacher ? $user : DB::select('*', 'users', "ID = '{$class['teacherID']}'");

if($isTeacher) {
    if(isset($_POST['requestAction'])) {
        $requestID = htmlspecialchars($_POST['requestID']);
        $action = htmlspecialchars($_POST['requestAction']);
        if($action == 'accept') {
            approve_join_request($requestID);
        } elseif($action == 'reject') {
            deny_join_request($requestID);
        }
    }

    if(isset($_POST['invite'])) {
        send_join_invite($class);
    }

    $requests = Utils::get_array(DB::select('*', 'joinRequests', "classID = '$classID'"));
} else {
    $times = json_decode($class['times'], true);
}


?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <?php if($isTeacher): ?>
    <div class="col gap-1r">
        <h2>Join Requests</h2>
        <?php if(count($requests) <= 0): ?>
            <p class="bubble black bold" style="font-size: medium;">No requests yet...</p>
        <?php else: ?>
            <div class="col">
                <?php foreach($requests as $request): ?>
                    <form class="row al-c space-between gap-1r" method="post">
                        <p class="w-80 bubble black bold"><?php echo $request['message'] ?></p>
                        <input type="hidden" name="requestID" value="<?php echo $request['ID'] ?>">
                        <div class="row" style="gap: 0.2rem;">
                            <button class="bubble green clickable" type="submit" name="requestAction" value="accept"><i class="fas fa-check"></i></button>
                            <button class="bubble red horizontal" type="submit" name="requestAction" value="reject"><i class="fas fa-times"></i></button>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h2>Invite Students</h2>
        <form action="" method="post" class="col gap-05r">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="message" placeholder="Message">
            <button class="w-100 bubble green clickable" type="submit" name="invite" value="send"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
    <?php else: ?>
        <div class="col gap-2r">
            <h2>Do you want to join this class?</h2>
            <div class="class-card">
                <div class="row al-c space-between">
                    <p class=""><?php echo $class['name'] ?></p>
                    <div class="row gap-05r al-c">
                        <p class="f-large"> <?= $teacher['name'] ?> </p>
                        <img src=<?= $teacher['image'] ?> alt="" class="profile-img" style="width: 32px; height: 32px;">
                    </div>
                </div>

                <?php if(count($times) > 0): ?>
                    <div id="time-container">
                        <?php foreach($times as $time): ?>
                            <p class="time"><?= $time['day'] ?> <?= $time['start'] ?> - <?= $time['end'] ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="bubble black bold" style="font-size: medium;">This class has no available times...</p>
                <?php endif; ?>
            </div>

            <?php if($isLogged): ?>
                <?php if($waitingForApproval): ?>
                    <h3>You are already waiting to join this class...</h3>
                <?php else: ?>
                    <form class="col gap-05r" method="post">
                        <input type="text" name="message" placeholder="Enter your message">
                        <button type="submit" name="join_class" class="w-100 bubble black bold clickable">Send a request to join</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <h3>You will need an account for that...</h3>
                <div class="row gap-1r">
                    <a class="w-100 bubble <?php echo rand_color(); ?> bold clickable" href="index.php">Are you new here?</a>
                    <a class="w-100 bubble <?php echo rand_color(); ?> bold clickable" href="index.php">Already have an account?</a>
                </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>


<?php include('comps/footer.php') ?>
