<?php

?>

<form class="col" action="index.php" method="POST" style="min-height: 100%; gap: 16px;">
    <h1>Register</h1>
    <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
    <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
    <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
    <select name="role" id="role">
        <option value="Student">Student</option>
        <option value="Teacher">Teacher</option>
    </select>
    <span class="text-error"> <?php echo $errRegister ?> </span>
    <input style="min-width: 12rem; max-width: 12rem;" type="submit" value="Register" class="btn-main">
</form>
