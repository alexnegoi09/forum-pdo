<?php
require('../includes/header.php');
require('../includes/thread.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

// check for valid id
Thread::categoryCheck();

// retrieve and display threads from db
Thread::read();


 ?>
