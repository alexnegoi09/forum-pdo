<?php 
require('../classes/Database.php');
require('../classes/Signup.php'); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New account - My Forum</title>
</head>
<body>
    <h1><a href="/forum-pdo/index.php">My Forum</a></h1>

    <h2>Create a new account</h2>

    <form action="signup.php" class="signup-form" method="POST">
        <p>
            <label for="username">Username:*</label>
            <input type="text" name="username" maxlength="25">
        </p>
        <p>
            <label for="password">Password:*</label>
            <input type="password" name="password">
        </p>
        <p>
            <label for="repass">Re-type Password:*</label>
            <input type="password" name="repass">
        </p>
        <p>
            <label for="username">E-mail:*</label>
            <input type="email" name="email" maxlength="50">
        </p>
        <p>* - required</p>
        <p>
            <button type="submit" name="submit">Create Account</button>
            or <a href="login.php">log in.</a>
        </p>
    </form>
</body>
</html>


<?php

if (isset($_POST['submit'])) {
    $signup = new Signup($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['repass'], $_POST['email'], $db);

    if (empty($_SESSION['errors'])) {
    $signup->store();

    } else {
            foreach($_SESSION['errors'] as $err) {
            echo '<p>' . $err . '</p>';
            }

        $_SESSION['errors'] = null;
    }

    $db = null;
}

require('../includes/footer.php');
?>