<?php

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'logout') {
        $_SESSION = [];
        header('Location: /forum-pdo/index.php');
        exit();
    } 
}

?>