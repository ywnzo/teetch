<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $errors = [];

    if(empty($name)) {
        $errors[] = 'Name is required';
    }

    if(empty($email)) {
        $errors[] = 'Email is required';
    }


    if(empty($errors)) {
        DB::update('users', "name = '$name', email = '$email'", "id = '{$_COOKIE['userID']}'");
    }
}

$image = $user['image'];

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <form method="post" class="w-100 col space-between gap-2r">
        <h2>Edit Profile</h2>

        <div class="w-100 col gap-05r">
            <input type="text" name="name" value="<?php echo $user['name']; ?>">
            <input type="email" name="email" value="<?php echo $user['email']; ?>">
        </div>

        <div class="w-100 col al-c gap-05r">
            <img src="<?php echo $image ? $image : 'public/img/profile-default.svg'; ?>" alt="" class="profile-img" style="width: 180px; height: 180px;">

            <div class="file-select" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <button type="button" class="bubble bold clickable red"onclick="file_explorer_single();">Select Image</button>
                <input type="file" id="select-file-single" name="image" accept="image/*">
            </div>

        </div>

        <button type="submit" name="save" class="w-100 bubble black bold clickable">Save</button>
    </form>

</div>


<?php include('comps/footer.php') ?>

<script src="public/js/file_upload_single.js?v=<?php echo  filemtime('public/js/file_upload_single.js'); ?>"></script>
