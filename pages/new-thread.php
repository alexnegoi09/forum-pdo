<?php 
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

if (!isset($_SESSION['username'])) {
    header('Location: /forum-pdo/index.php');
}

// check for valid id
Thread::categoryCheck();

?>

<h2>Start a new thread</h2>

<form action="" method="POST">
    <p>
    <input type="text" name="thread-title" maxlength="255">
    </p>
    <p>
    <input type="submit" name="btn" value="Create Thread">
    </p>
</form>

<?php

if (isset($_POST['btn'])) {
    // check for empty form
    Thread::emptyTitleCheck();

    // check for duplicate thread
    Thread::duplicateCheck();

    //create new thread
    $thread = new Thread($_POST['thread-title']);  
    $thread->create();
    
} 

?>
