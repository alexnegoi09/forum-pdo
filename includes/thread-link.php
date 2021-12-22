<?php
if (!isset($_SESSION['username'])) {
    echo 'To create a thread, you must log in or create an account!';
} else {
    echo '<p><a href="/forum-pdo/pages/new-thread.php?id=' . $_GET['id'] .  '">new thread</a></p>';
}

?>