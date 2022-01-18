<?php
if (!isset($_SESSION['username'])) {
    echo '<p><i>To create a thread, you must log in or create an account!</i></p>';
} else {
    echo '<p class="thread-link"><a href="/forum-pdo/pages/new-thread.php?id=' . $_GET['id'] .  '" class="btn btn-success"><span class="bi bi-plus-circle"></span>New thread</a></p>';
}

?>