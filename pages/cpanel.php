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
    </form>
</body>
</html>
