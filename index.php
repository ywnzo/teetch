<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(isset($_GET['url'])) {
    $id = $_GET['url'];
    $url = DB::select('original', 'urls', "short = '$id'");
    if($url) {
        $url = $url['original'];
        header("Location: $url");
    }
}

if(!$authOK) {
    include('auth.php');
}

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <?php if(!$authOK): ?>
        <div style="">
            <h1 class="title-main">TEECH</h1>
            <h2 style="margin-bottom: 2rem;">Easily manage your classes!</h2>
            <div class="row" style="justify-content: center; height: 80%; gap: 2rem;">
                <?php include('comps/auth/login_form.php'); ?>
                <?php include('comps/auth/register_form.php'); ?>
            </div>
        </div>
    <?php else: ?>
        <?php include('comps/home.php') ?>
    <?php endif ?>
</div>

<?php include('comps/footer.php') ?>

<script src="public/js/index.js"></script>
