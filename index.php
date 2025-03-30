<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(!$authOK) {
    include('auth.php');
}

$action = $_GET['action'] ?? 'login';
if($action != 'login' && $action != 'register') {
    $action = 'login';
}

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <?php if(!$authOK): ?>
        <div class="col al-s gap-2r">
            <div class="col gap-05r">
                <h2 style="align-self: start;" class="bubble yellow">Manage classes.</h2>
                <h2 style="align-self: end;" class="bubble blue">Update students.</h2>
                <h2 style="align-self: start;" class="bubble green">Create lesson plans.</h2>
                <h2 style="align-self: end;" class="bubble orange">All in one place!</h2>
            </div>

            <?php if($action === 'login'): ?>
                <?php include('comps/auth/login_form.php'); ?>
            <?php elseif($action === 'register'): ?>
                <?php include('comps/auth/register_form.php'); ?>
            <?php endif; ?>

            <div class="col gap-1r" style="margin-top: 1rem;">
                <h2>Check out my other projects</h2>
                <div class="promo-link-wrapper">
                    <a class="promo-link" href="https://flard.free.nf">FLARD</a>
                    <img class="promo-img" src="public/img/flard/flard_sets.png" alt="">
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php include('comps/home.php') ?>
    <?php endif ?>
</div>

<?php include('comps/footer.php') ?>
