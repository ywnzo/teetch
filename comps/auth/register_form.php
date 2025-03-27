<?php

?>

<form class="col" action="index.php?action=register" method="POST" style="min-height: 100%; gap: 16px;">
    <h1>Register</h1>
    <div class="col gap-05r">
        <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
        <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
        <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
        <select name="role" id="role">
            <option value="Student">Student</option>
            <option value="Teacher">Teacher</option>
        </select>
    </div>

    <a href="?action=login" class="horizontal">Already have an account?</a>
    <button type="submit" value="Register" class="bubble black bold clickable">Register</button>
    <span class="text-error"> <?php echo $errRegister ?> </span>

</form>
