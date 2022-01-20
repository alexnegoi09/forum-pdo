<?php

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'logout') {
        $_SESSION = [];
        setcookie('remember', '', time() - 1, '/');
        header('Location: /forum-pdo/index.php');
        exit();
    } 
}

?>