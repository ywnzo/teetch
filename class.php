<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
<?php
if(isset($_GET['action'])) {
    $action = $_GET['action'];
    if($action == 'create') {
        include('comps/classes/create_class.php');
        include('comps/classes/view_classes.php');
    } elseif($action == 'view') {
        include('comps/classes/view_class.php');
    } elseif($action == 'edit') {
        include('comps/classes/edit_class.php');
    }
}

?>
</div>

<?php include('comps/footer.php') ?>
