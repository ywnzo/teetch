<?php

?>

<?php if(empty($classes)): ?>
    <p class="bubble black bold">You have no classes.</p>
<?php else: ?>
    <?php foreach($days as $dayName): ?>
        <?php $day = $classesSorted[$dayName]; ?>
        <?php if(!empty($day)): ?>
            <div class="col gap-05r">
                <h3 class="bubble black"><?= $dayName ?></h3>
                <div class="col" style="gap: 0.2rem;">
                    <?php foreach ($day as $class): ?>
                        <a href="class.php?action=view&class=<?= $class['ID'] ?>" class="list-item <?php echo rand_color(); ?> horizontal" title="<?= $class['name'] ?>">
                            <h3 class="f-large t-over-el"><?= $class['name'] ?></h3>
                            <div class="row gap-05r bold">
                                <p class=""><?php echo $class['time']['start']; ?> - <?php echo $class['time']['end']; ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
