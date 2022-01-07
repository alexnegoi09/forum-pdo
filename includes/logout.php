<?php

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'logout') {
        $_SESSION = [];
        setcookie('remember', $rememberToken, time() - 1, '/');
        header('Location: /forum-pdo/index.php');
        exit();
    } 
}

?>