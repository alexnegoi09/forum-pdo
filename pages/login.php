<?php
require('../classes/Database.php');
require('../classes/Login.php'); 
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - My Forum</title>
</head>
<body>
    <h1><a href="/forum-pdo/index.php">My Forum</a></h1>

    <h2>Log in</h2>

    <form action="login.php" class="login-form" method="POST">
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" class="username-input">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" name="password">
        </p>
        <p>
            <label for="checkbox">Stay logged in</label>
            <input type="checkbox" name="checkbox">
        </p>
        <p>
            <button type="submit" name="submit">Log In</button>
            or <a href="signup.php">create a new account.</a>
        </p>
    </form>
</body>
</html>


<?php

if (isset($_POST['submit'])) {
    if (!empty($_POST['username'] && !empty($_POST['password']))) {
        $login = new Login($_POST['username'], $_POST['password'], $db);
        $login->validate();
    } else {
        echo '<p>Please enter a username and password!</p>';
    }
   
    $db = null;

}

require('../includes/footer.php');
?>