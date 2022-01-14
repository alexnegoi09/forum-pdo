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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <h1 class="main-header"><a href="/forum-pdo/index.php">My Forum</a></h1>

    <form action="signup.php" class="signup-form" method="POST">
    <h2 class="main-title">Create a new account</h2>
        <p>
            <label for="username" class="username-label">Username:*</label>
            <input type="text" name="username" class="form-control" maxlength="25">
        </p>
        <p>
            <label for="password" class="password-label">Password:*</label>
            <input type="password" name="password" class="form-control" maxlength="255">
        </p>
        <p>
            <label for="repass" class="repass-label">Re-type Password:*</label>
            <input type="password" name="repass" class="form-control" maxlength="255">
        </p>
        <p>
            <label for="username" class="email-label">E-mail:*</label>
            <input type="email" name="email" class="form-control" maxlength="50">
        </p>
        <p>* - required</p>
        <p>
            <button type="submit" name="submit" class="btn btn-success">Create Account</button>
            <a href="login.php" class="login-link">Log in</a>
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
            echo '<p class="text-danger error">' . $err . '</p>';
            }

        $_SESSION['errors'] = null;
    }

    $db = null;
}

require('../includes/footer.php');
?>