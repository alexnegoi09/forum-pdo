<?php 
require('../includes/header.php');
require('../includes/logout.php');
require('../classes/Database.php');
require('../classes/User.php');

if (isset($_SESSION['username'])) {
    if (!isset($_GET['user_id'])) {
        header('Location: /forum-pdo/index.php');
    }
} else {
    header('Location: /forum-pdo/pages/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum - User Profile: <?php echo $_SESSION['username']; ?></title>
</head>
<body>
    <button class="back">Go back</button>
    
    <?php
    $user = new User(null, null, null, null, null, null, $db);
    $user->getProfileInfo();
    $db = null; 
     ?>

    <?php require('../includes/footer.php'); ?>
    <script src="../js/nav.js"></script>
</body>
</html>