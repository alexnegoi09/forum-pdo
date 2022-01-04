<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');


if (isset($_SESSION['username'])) {

    if ($_SESSION['groups'] !== 'Administrator' && $_SESSION['groups'] !== 'Moderator')  {
        header('Location: /forum-pdo/index.php');

    } else {

    $thread = new Thread($_GET['category_id'], null, null, $db);
    $thread->categoryCheck();
    $thread->threadCheck();
    $thread->delete();
    echo '<p>Thread deleted! Click <a href="/forum-pdo/pages/categories.php">here</a> to go back.</p>';
    }
}