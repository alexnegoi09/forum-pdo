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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/nav-main.css">
    <link rel="stylesheet" href="../css/footer-main.css">
    <link rel="stylesheet" href="../css/threads.css">
</head>
<body>
    <?php

    $post = new Post($_GET['id'], null, null, $db);

    //check for valid id
    $post->threadPostCheck();
    ?>

    <div class="main-container">
        <?php
            //display forum navigation
        $nav = new Navigation($db);
        $nav->display();

        // display thread title
        echo '<h3 class="thread-title"><p>Thread: <strong>' . $thread->getTitle() . '</strong></p></h3>';

        // display posts
        $post->read();
        $post->pagination();

        $db = null;


        if ($post->isThreadLocked() === 0) {
            require('../includes/post-link.php');
        } else {
            echo '<p class="btn btn-outline-danger"><span class="bi bi-lock"></span>Locked</p>';
        }

        ?>
    </div>

    <?php require('../includes/footer.php'); ?>
    
    <script src="../js/user-color.js"></script>
</body>
</html>

