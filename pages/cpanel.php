<?php
require('../includes/header.php');
require('../includes/logout.php');
require('../classes/Database.php');
require('../classes/User.php'); 

if (!isset($_SESSION['username'])) {
    header('Location: /forum-pdo/index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username'] . ' -  Control Panel - My Forum' ?></title>
</head>
<body>
    <?php
        $user = new User(null, null, null, null, null, null, $db);
        $user->getPageTitle();
    ?>

    <form action="" method="POST">
        <p>
            <label for="username">Username: </label>
            <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" disabled>
        </p>
        <p>
            <label for="password">New password: </label>
            <input type="password" name="password">
        </p>
        <p>
            <label for="repass">Re-type password: </label>
            <input type="password" name="repass">
        </p>
        <p>
            <label for="profilepic">Change profile picture:</label>
            <input type="file" name="profilepic">
            <pre>The maximum resolution of the picture must be 200x200px, and the maximum size must be 2 MB!</pre>
        </p>
        <p>
            <label for="location">Location: </label>
            <input type="text" name="location">
        </p>
        <p>
            <input type="submit" name="update" value="Update info">
        </p>
    </form>

    <?php 
        if (isset($_POST['update'])) {
            $user = new User($_SESSION['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['repass'], null, null, null, $db);
            $user->updatePassword();

            if (!empty($_SESSION['errors'])) {
                foreach($_SESSION['errors'] as $err) {
                    echo '<p>' . $err . '</p>';
                }
            } else {
                echo '<p>Your user information has been updated!</p>';
            }
        }
    ?>

    <?php if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') { ?>

        <h4>Forum Controls</h4>

        <form action="" method="POST">
            <p>Number of warnings received: </p>
    
            <p>
                <label for="lock">Lock or unlock a thread: </label>
                <select name="lock"></select>
                <input type="submit" value="Lock">
                <input type="submit" value="Unlock">
            </p>
            <p>
                <label for="warn">Warn users: </label>
                <select name="warn"></select>
                <input type="submit" value="Warn user">
            </p>

            <?php if($_SESSION['groups'] === 'Administrator') { ?>

            <p>
                <label for="ban">Ban users: </label>
                <select name="ban"></select>
                <input type="submit" value="Ban user">
            </p>
                <?php } ?>
    <?php } ?>
        </form>


    
</body>
</html>
