<form class="col" action="index.php" method="POST" style="min-height: 100%; gap: 16px;">
    <h1>Login</h1>
    <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
    <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
    <span class="text-error"> <?php echo $errLogin ?>  </span>
    <input style="min-width: 12rem; max-width: 12rem;" type="submit" value="Login" class="btn-main">
</form>
