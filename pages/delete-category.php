<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Category.php');


if (isset($_SESSION['username'])) {

    if ($_SESSION['groups'] !== 'Administrator') {
        header('Location: /forum-pdo/index.php');
        
    } else {

    $category = new Category(null, null, $db);
    $category->messageCheck();
    $category->delete();
    echo '<p>Category deleted! Click <a href="/forum-pdo/index.php">here</a> to go back.</p>';
    }
}

?>