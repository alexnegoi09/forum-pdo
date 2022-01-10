<?php
require('../classes/Database.php');
require('../classes/Thread.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php'); 
require('../classes/Navigation.php');
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
    <?php

    $post = new Post($_GET['id'], null, null, $db);

    //check for valid id
    $post->threadPostCheck();

    //display forum navigation
    $nav = new Navigation($db);
    $nav->display();

    // display thread title
    echo '<h3>Thread: ' . $thread->getTitle() . '</h3>';

    // display posts
    $post->read();
    $post->pagination();

    $db = null;


    if ($post->isThreadLocked() === '0') {
        require('../includes/post-link.php');
    } else {
        echo '<p>Locked</p>';
    }

    require('../includes/footer.php');
    ?>
</body>
</html>

