<?php
require('../includes/header.php');
require('../includes/thread.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

// check for valid id
Thread::categoryCheck();

// retrieve and display threads from db
Thread::read();

// check if signed in
require('../includes/new-thread.php');

if (isset($_POST['btn'])) {

    // check for empty form
    Thread::titleCheck();

    // check for duplicate thread
    Thread::duplicateCheck();

    //create new thread
    $thread = new Thread($_POST['thread-title']);  
    $thread->create();
} 
 ?>