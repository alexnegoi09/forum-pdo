<?php 
if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator') {
        echo '<p class="category-link"><a href="/forum-pdo/pages/new-category.php" class="btn btn-primary"><span class="bi bi-plus-circle"></span>New category</a></p>';
    } 
}   
?>