<?php 
if (!isset($_SESSION['username'])) { 
echo 'To post a message, you must log in or create an account!'; 
 } else {
echo '<p><a href="/forum-pdo/pages/new-post.php?id=' . $_GET['id'] .  '">new post</a></p>';
}   
?>