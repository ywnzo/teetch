<form class="col" action="index.php?action=login" method="POST" style="min-height: 100%; gap: 16px;">
    <h1>Login</h1>
    <div class="col gap-05r">
        <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
        <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
    </div>

    <a class="horizontal" href="index.php?action=register">Need an account?</a>
    <button type="submit" value="login" class="bubble black bold clickable">Login</button>
    <span class="bold"> <?php echo $errLogin ?>  </span>

</form>
