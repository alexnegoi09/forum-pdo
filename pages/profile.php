<?php 
require('../includes/header.php');
require('../includes/logout.php');
require('../includes/database.php');
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
    <div>
        <div>
            <img src="" alt="">
        </div>
        <h2>User Profile - <?php echo $_SESSION['username']; ?></h2>
    </div>

    <div>
        <h3>Statistics</h3>
        <p>Profile picture: <?php echo $_SESSION['profilepic']; ?></p>
        <p>E-mail: <?php echo $_SESSION['email']; ?></p>
        <p>Join date: <?php echo $_SESSION['joined']; ?></p>
        <p>Rank: <?php echo $_SESSION['groups']; ?></p>
        <p>Number of posts: <?php echo $_SESSION['postcount']; ?></p>
        <p>Location: <?php echo $_SESSION['location']; ?></p>

    </div>

</body>
</html>