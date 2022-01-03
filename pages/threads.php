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
    <title><?php $thread = new Thread(null, null, null, $db); $thread->getPageTitle(); ?></title>
</head>
<body>
    
</body>
</html>

<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

$post = new Post($_GET['id'], null, $_SESSION['username'], $db);

//check for valid id
$post->threadPostCheck();

// display thread title
echo '<h3>Thread: ' . $thread->getTitle() . '</h3>';

// display posts
$post->read();
$post->pagination();

$db = null;

// check if signed in 
require('../includes/post-link.php');

require('../includes/footer.php');
?>