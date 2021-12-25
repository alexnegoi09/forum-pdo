<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

//check for valid id
Post::threadPostCheck();

// display posts
Post::read();
Post::pagination();

// check if signed in 
require('../includes/post-link.php');
?>