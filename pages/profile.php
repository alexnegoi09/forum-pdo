<?php 
require('../includes/header.php');
require('../includes/logout.php');
require('../classes/Database.php');
require('../classes/Login.php');

if (!isset($_GET['user_id'])) {
    header('Location: /forum-pdo/index.php');
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
    
    <?php Login::userProfileInfo($db) ?>

<?php require('../includes/footer.php'); ?>
</body>
</html>