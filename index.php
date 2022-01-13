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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>

    <div class="main-container">
        <?php
        require('classes/Category.php');
        $category = new Category(null, null, $db);
        $category->read();

        // close connection
        $db = null;

        require('includes/category-link.php');
        ?>
    </div>
   <?php require('includes/footer.php'); ?>
   
   <script src="js/user-color.js"></script> 
</body>
</html>