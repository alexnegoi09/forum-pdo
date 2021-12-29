<?php
require('../classes/Database.php');
require('../classes/Thread.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php Thread::getPageTitle($db); ?></title>
</head>
<body>
    
</body>
</html>

<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

//check for valid id
Post::threadPostCheck($db);

// display thread title
echo '<h3>Thread: ' . Thread::getTitle($db) . '</h3>';

// display posts
Post::read($db);
Post::pagination($db);

// check if signed in 
require('../includes/post-link.php');

require('../includes/footer.php');
?>