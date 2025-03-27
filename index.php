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
        <div class="col al-c gap-3r">
            <h1 style="text-align: center;">Easily manage your classes!</h1>
            <div class="row js-c">
                <?php if($action === 'login'): ?>
                    <?php include('comps/auth/login_form.php'); ?>
                <?php elseif($action === 'register'): ?>
                    <?php include('comps/auth/register_form.php'); ?>
                <?php endif; ?>
            </div>

            <h3 style="text-align: center; font-color: var(--red);">Try also our flash cards platform called <a class="bold clickable" href="https://flard.free.nf" target="_blank">FLARD</a></h3>
        </div>
    <?php else: ?>
        <?php include('comps/home.php') ?>
    <?php endif ?>
</div>

<?php include('comps/footer.php') ?>

<script src="public/js/index.js"></script>
