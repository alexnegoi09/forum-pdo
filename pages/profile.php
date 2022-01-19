<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
<?php 
require('../includes/header.php');
require('../includes/logout.php');
require('../classes/Database.php'); 
require('../classes/User.php');


if (isset($_SESSION['username'])) {
    if (!isset($_GET['user_id'])) {
        header('Location: /forum-pdo/index.php');
        exit();
    }
} else {
    header('Location: /forum-pdo/pages/login.php');
    exit();
}

?>

    <button class="back btn btn-outline-dark">Go back</button>
    
    <?php
    $user = new User(null, null, null, null, null, null, $db);
    $user->getProfileInfo();
    $db = null; 
    ?>

    <?php require('../includes/footer.php'); ?>
    
    <script src="../js/nav.js"></script>
    <script src="../js/user-color.js"></script> 
</body>
</html>