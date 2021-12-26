<?php 
if (!isset($_SESSION['username'])) { 
echo '<p>To post a message, you must log in or create an account!</p>'; 
 } else {
echo '<p><a href="/forum-pdo/pages/new-post.php?id=' . $_GET['id'] .  '&page=' . $_GET['page'] .   '">new post</a></p>';
}   
?>