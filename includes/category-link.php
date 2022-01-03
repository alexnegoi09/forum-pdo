<?php 
if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator') {
        echo '<p><a href="/forum-pdo/pages/new-category.php">new category</a></p>';
    } 
}   
?>