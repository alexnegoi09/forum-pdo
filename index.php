<?php
require('includes/header.php');
require('includes/logout.php');
require('classes/Database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Forum</title>
</head>
<body>
    <?php 
        require('classes/Category.php');
        Category::read($db); 
    ?>

<?php require('includes/footer.php'); ?>
</body>
</html>