<?php

function rand_color() {
    $colors = ['red', 'green', 'yellow', 'purple', 'cyan', 'orange', 'violet'];
    return $colors[array_rand($colors)];
}

$pageName = basename($_SERVER['SCRIPT_NAME']);
$pageName = explode('.', $pageName)[0];
$pageName = str_replace('_', ' ', $pageName);
$pageName = str_replace('-', ' ', $pageName);
$pageName = ucfirst($pageName);

if($pageName == 'Index') {
    $pageName = 'Home';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Oldenburg&display=swap&family=Galindo&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="public/img/logo.png">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo  filemtime('public/css/style.css'); ?>">

    <script src="https://kit.fontawesome.com/fd483a54f1.js" crossorigin="anonymous"></script>

    <script src="public/js/index.js"></script>
    <script src="public/js/cookies.js" defer></script>
    <script src="public/js/file_upload.js" defer></script>
    <script src="public/js/file_upload_single.js" defer></script>
    <script src="public/js/chat.js" defer></script>
    <script src="public/js/class_levels.js" defer></script>
    <script src="public/js/create_class.js" defer></script>
    <script src="public/js/level_requirements.js" defer></script>

    <title>Teetch - <?php echo $pageName ?></title>
</head>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q32TZVY36W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Q32TZVY36W');
</script>


<body>
<script>0</script>
<div class="header">
    <div class="nav">
        <div class="row al-c gap-1r">
            <a class="row al-c select-none" href="index.php" style="overflow: hidden; border-radius: 8px;">
                <h1 class="clickable <?php echo rand_color(); ?>">T</h1>
                <h1 class="clickable <?php echo rand_color(); ?>">e</h1>
                <h1 class="clickable <?php echo rand_color(); ?>">e</h1>
                <h1 class="clickable <?php echo rand_color(); ?>">t</h1>
                <h1 class="clickable <?php echo rand_color(); ?>">c</h1>
                <h1 class="clickable <?php echo rand_color(); ?>">h</h1>
            </a>
        </div>

        <ul class="row gap-05r al-c">

            <?php if(isset($user)): ?>
                <li>
                    <a class="nav-link bubble clickable black" href="class.php?action=create" title="Classes">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </a>
                </li>
                <?php if($user['role'] == 'Teacher'): ?>
                    <li>
                        <a class="nav-link bubble clickable black" href="levels.php" title="Levels">
                            <i class="fa-solid fa-stairs"></i>
                        </a>
                    </li>
                <?php endif; ?>
                </li>
                <li>
                    <a class="row al-c bold clickable" href="profile.php?user=<?php echo $userID; ?>" title="Your profile">
                        <img class="profile-img" style="width: 38px; height: 38px; " src=<?= $user['image']; ?> alt="">
                    </a>
                </li>
                <li>
                    <a class="nav-link bubble horizontal red" href="logout.php" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <p class="nav-link bubble red"title="Made with love">
                        <i class="fa-solid fa-heart"></i>
                    </p>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<div class="background"></div>
