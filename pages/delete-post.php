<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

if (isset($_SESSION['username'])) {
    $post = new Post($db);
    $post->messageCheck();

    if ($_SESSION['post_author'] === $_SESSION['username'] && time() < strtotime($_SESSION['created_at']) + 3600) {
        $post->delete();
        $post->getPostCount();
        $post->setPostCount();
        echo '<p>Your message has been deleted! Click <a href="/forum-pdo/pages/threads.php?id=' . $_GET['thread_id'] . '&page=' . $_GET['page'] . '">here</a> to go back to the thread.</p>';
    } else if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {
        $post->delete();
        $post->getPostCount();
        $post->setPostCount();
        echo '<p>Message deleted! Click <a href="/forum-pdo/pages/threads.php?id=' . $_GET['thread_id'] . '&page=' . $_GET['page'] . '">here</a> to go back to the thread.</p>';
    }
} else {
    header('Location: index.php');
}

?>