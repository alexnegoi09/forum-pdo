<?php
require '../classes/Database.php';
require '../classes/Thread.php'; 
require '../classes/Category.php';
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $category = new Category(null, null, $db); $category->getPageTitle(); ?></title>
</head>
<body>
    
</body>
</html>

<?php
require('../includes/header.php');
require('../includes/logout.php'); 

// check for valid id
$thread = new Thread($_GET['id'], null, null, $db);
$thread->categoryCheck();

//display category title
echo '<h3>Category: ' . $category->getTitle() . '</h3>';

// retrieve and display threads from db
$thread->read();

$db = null;

// check if signed in
require('../includes/thread-link.php');

require('../includes/footer.php');
 ?>