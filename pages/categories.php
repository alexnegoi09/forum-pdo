<?php require '../classes/Category.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php Category::getPageTitle(); ?></title>
</head>
<body>
    
</body>
</html>

<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

// check for valid id
Thread::categoryCheck();

//display category title
echo '<h3>Category: ' . Category::getTitle() . '</h3>';

// retrieve and display threads from db
Thread::read();

// check if signed in
require('../includes/thread-link.php');

 ?>