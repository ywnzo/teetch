<?php

function get_teacher_name($id) {
    $teacher = DB::select('*','users', "ID = '$id'");
    return $teacher['name'];
}

function get_weekday($date, $method) {
    $month = explode('-', $date)[1];
    $day = explode('-', $date)[2];
    $year = explode('-', $date)[0];
    $jd = gregoriantojd($month, $day, $year);
    return jddayofweek($jd, $method);
}

include('comps/classes/sort_classes.php');

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$tomorrowTomorrow = date('Y-m-d', strtotime('+2 day'));

$todayWeekday = date('D d/m');
$tomorrowWeekday = date('D d/m', strtotime('+1 day'));
$toTomorrowWeekday = date('D d/m', strtotime('+2 day'));

?>

<div class="col gap-3r">
    <div class="col gap-1r">
        <div class="col gap-1r">
            <h2>Schedule</h2>
            <div id='schedule-table' class="w-100">
                <div class="row space-between bold" style="border-top-left-radius: 8px; border-top-right-radius: 8px; overflow: hidden;">
                    <p class="black schedule-col" style="height: auto; padding: 0.4rem 0rem;"><?php echo $todayWeekday ?></p>
                    <p class="black schedule-col" style="height: auto; padding: 0.4rem 0rem;"><?php echo $tomorrowWeekday ?></p>
                    <p class="black schedule-col" style="height: auto; padding: 0.4rem 0rem;"><?php echo $toTomorrowWeekday ?></p>
                </div>

                <div class="row space-between">
                    <div id="col-mon" class="schedule-col" style="
                        border-left: 2px solid var(--black);
                        border-bottom: 2px solid var(--black);
                        border-bottom-left-radius: 8px;">
                        <?php foreach($classesSorted[get_weekday($today, 2)] as $class): ?>
                            <div class="schedule-row-wrapper ">
                                <a title="<?php echo $class['name']; ?>" class="" href="class.php?action=view&class=<?= $class['ID'] ?>"><?php echo $class['name']; ?></a>
                            </div>
                        <?php endforeach ?>
                        <div class="schedule-row-wrapper ">
                            <a href="class.php?action=create&day=<?php echo date('D', strtotime($today)) ?>" class="bold" href="">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div id="col-tue" class="schedule-col" style="
                        border-left: 2px solid var(--black);
                        border-bottom: 2px solid var(--black);">
                        <?php foreach($classesSorted[get_weekday($tomorrow, 2)] as $class): ?>
                            <div class="schedule-row-wrapper ">
                                <a title="<?php echo $class['name']; ?>" class="" href="class.php?action=view&class=<?= $class['ID'] ?>"><?php echo $class['name']; ?></a>
                            </div>
                        <?php endforeach ?>
                        <div class="schedule-row-wrapper ">
                            <a href="class.php?action=create&day=<?php echo date('D', strtotime('+1 day')) ?>" title="No classes" class="" href="">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div id="col-wed" class="schedule-col" style="
                        border: 2px solid var(--black);
                        border-top: 0px;
                        border-bottom-right-radius: 8px;">
                        <?php foreach($classesSorted[get_weekday($tomorrowTomorrow, 2)] as $class): ?>
                            <div class="schedule-row-wrapper ">
                                <a title="<?php echo $class['name']; ?>" class="" href="class.php?action=view&class=<?= $class['ID'] ?>"><?php echo $class['name']; ?></a>
                            </div>
                        <?php endforeach ?>
                        <div class="schedule-row-wrapper ">
                            <a href="class.php?action=create&day=<?php echo date('D', strtotime('+2 day')) ?>" title="No classes" class="" href="">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col gap-1r">
        <div class="row al-c space-between">
            <h2 class="">Your Classes</h2>
            <a class="bubble <?php echo rand_color(); ?> horizontal" href="class.php?action=create">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        <div class="col gap-05r">
            <?php include('comps/classes/class_list.php'); ?>
        </div>
    </div>
</div>
