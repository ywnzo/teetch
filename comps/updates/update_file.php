<?php
    $ownerID = $update['ownerID'];
    $owner = DB:: select('name', 'users', "ID = '$ownerID'");
?>

<div class="update-item-wrapper gap-05r <?php echo $update['ownerID'] === $userID ? 'row' : 'row-rev' ?> al-e">
    <div class="update-item">
        <div class="update-content <?php echo rand_color() ?>">
            <?php if(isset($file)): ?>
                <?php if(in_array(pathinfo($file, PATHINFO_EXTENSION), $imgExts)) : ?>
                    <img class="update-img" src="<?php echo $file_path . $file?>" alt="">
                <?php else: ?>
                    <a class="update-file" href="download.php?file=<?php echo $file ?>">
                        <i style="font-size: xx-large;" class="fa-solid fa-download"></i>
                        <?php echo Utils::get_file_name($file) ?>
                    </a>
                <?php endif ?>
            <?php endif; ?>
        </div>

        <div class="row bold space-between al-c">
            <a class="horizontal" href="profile.php?id=<?php echo $ownerID ?>">
                <div class="row al-c gap-05r">
                    <img class="profile-img" style="width: 2rem; height: 2rem;" src="public/img/profile-default.png" alt="">
                    <p><?php echo $owner['name'] ?></p>
                </div>
            </a>

            <div class="row al-c gap-05r">
                <p><?php echo Utils::get_date($update['createdAt']) ?></p>
                <?php if($ownerID === $userID): ?>
                    <div class="row gap-05r">
                        <button id="<?php echo $update['ID'] ?>" class="update-control-btn update-delete-btn clickable black"><i class="fa-solid fa-trash"></i></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
