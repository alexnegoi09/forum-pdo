<?php 
if (!isset($_SESSION['username'])) { 
echo '<p><i>To post a message, you must log in or create an account!<i></p>'; 
 } else {
echo '<p class="post-link"><a href="/forum-pdo/pages/new-post.php?id=' . $_GET['id'] .  '&page=' . $_GET['page'] .   '" class="btn btn-success"><span class="bi bi-plus-circle"></span>New post</a></p>';
}   
?>