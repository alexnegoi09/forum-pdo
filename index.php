<?php
require('includes/header.php');
require('includes/logout.php');
require('classes/Database.php');
require('classes/Login.php');

if (isset($_COOKIE['remember'])) {
    $login = new Login(null, null, $db);
    $login->stayLoggedIn();
}

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
        $category = new Category(null, null, $db);
        $category->read();
        print_r($_COOKIE);
        
        // close connection
        $db = null;
    ?>

    <?php 
    require('includes/category-link.php');
    require('includes/footer.php'); 
    ?>
    
</body>
</html>