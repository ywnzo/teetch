<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

$image = $user['image'];

?>

<?php include('comps/header.php') ?>

<div class="content-wrapper">
    <form method="post" class="w-100 col space-between gap-2r">
        <h2>Edit Profile</h2>

        <div class="w-100 col gap-05r">
            <input type="text" name="name" value="<?php echo $user['name']; ?>">
            <input type="email" name="email" value="<?php echo $user['email']; ?>">
            <select name="role" id="">
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
            </select>
        </div>

        <div class="w-100 col al-c gap-05r">
            <img src="public/img/profile-default.png" alt="public/img/profile-default.png" class="profile-img" style="width: 180px; height: 180px;">

            <div class="file-select">
                <button type="button" class="bubble bold clickable red"onclick="file_explorer();">Select Image</button>
                <input type="file" id="select-file" name="image" accept="image/*">
            </div>

        </div>

        <button type="submit"class="w-100 bubble black bold clickable">Save</button>
    </form>

</div>


<?php include('comps/footer.php') ?>

<script type="module" src="public/js/cookies.js"></script>
<script src="public/js/file_upload_single.js"></script>
