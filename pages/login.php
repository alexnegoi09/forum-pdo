<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <?php   
        require('../classes/Database.php');
        require('../classes/Login.php');

        if (isset($_COOKIE['remember'])) {
            header('Location: /forum-pdo/index.php');
            exit();
        }
    ?>

    <h1 class="main-header"><a href="/forum-pdo/index.php">My Forum</a></h1>

    <form action="login.php" class="login-form" method="POST">
        <h2 class="main-title">Log in</h2>
        <p>
            <label for="username" class="username-label">Username:</label>
            <input type="text" name="username" class="form-control" maxlength="25">
        </p>
        <p>
            <label for="password" class="password-label">Password:</label>
            <input type="password" name="password" class="form-control" maxlength="255">
        </p>
        <p>
            <button type="submit" name="submit" class="btn btn-success">Log in</button>
        </p>
        <p>
            <label for="checkbox" class="checkbox-label form-check-label">Stay logged in</label>
            <input type="checkbox" name="checkbox" class="form-check-input">
        </p>
        <p>
            <a href="signup.php" class="account-link">Create a new account</a>
        </p>
    </form>

    <?php

        if (isset($_POST['submit'])) {
            if (!empty($_POST['username'] && !empty($_POST['password']))) {
                $login = new Login($_POST['username'], $_POST['password'], $db);
                $login->validate();
            } else {
                echo '<p class="text-danger error">Please enter a username and password!</p>';
            }
   
            $db = null;

        }

        require('../includes/footer.php');
    ?>
</body>
</html>