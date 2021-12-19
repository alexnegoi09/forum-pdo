<?php
require('includes/header.php');
require('includes/logout.php');
require('includes/database.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum - Home</title>
</head>
<body>
    <?php 
        require('classes/Category.php');
        $category = new Category();
        $category->read(); 
    ?>

</body>
</html>