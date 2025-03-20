<?php


?>

<h2>Add a new level set</h2>
<form method="POST" action="" class="col gap-05r">
    <input type="text" id="name" name="name" placeholder="Enter level set name" required>
    <button class="bubble bold clickable <?php echo rand_color() ?>" name="add_level_set" type="submit"><i class="fa-solid fa-plus"></i></button>
</form>

<h2>Your level sets</h2>
<div class="col" style="gap: 0.2rem">
    <?php if(empty($levelSets)): ?>
        <p class="bubble black bold">You have no level sets.</p>
    <?php else: ?>
        <?php foreach($levelSets as $set): ?>
            <div class="row space-between gap-05r">
                <a href="levels.php?set=<?php echo $set['ID'] ?>" class="w-100 bubble <?php echo rand_color() ?> bold horizontal">
                    <p><?php echo $set['name'] ?></p>
                </a>
                <a href="levels.php?set=<?php echo $set['ID'] ?>&action=deleteSet" class="bubble clickable red bold">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
