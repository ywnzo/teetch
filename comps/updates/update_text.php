<?php
    $ownerID = $update['ownerID'];
    $owner = DB:: select('name', 'users', "ID = '$ownerID'");
    $ownerImage = isset($owner['image']) ? htmlspecialchars($owner['image']) : 'public/img/profile-default.svg';
?>

<div class="update-item-wrapper <?php echo $update['ownerID'] === $userID ? 'row' : 'row-rev' ?> al-e gap-05r">
    <div class="update-item">
        <div class="update-content <?php echo rand_color() ?>">
            <?php if(isset($update['text'])): ?>
                <div class="update-text-container">
                    <textarea id="<?php echo $update['ID'] ?>" class="bold update-text" style="pointer-events: none;" cols="1" spellcheck="false"><?php echo $update['text']?></textarea>
                </div>
            <?php endif; ?>
        </div>

        <div class="row bold space-between al-c">
            <a class="horizontal" href="profile.php?id=<?php echo $ownerID ?>">
                <div class="row al-c gap-05r">
                    <img class="profile-img" style="width: 2rem; height: 2rem;" src="<?php echo $ownerImage ?>" alt="">
                    <p><?php echo $owner['name'] ?></p>
                </div>
            </a>

            <div class="row al-c gap-05r">
                <p><?php echo Utils::get_date($update['createdAt']) ?></p>
                <?php if($ownerID === $userID): ?>
                    <div class="row gap-05r">
                        <button id="<?php echo $update['ID'] ?>" class="update-control-btn update-edit-btn clickable black"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button id="<?php echo $update['ID'] ?>" class="update-control-btn update-delete-btn clickable black"><i class="fa-solid fa-trash"></i></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
