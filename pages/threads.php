<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');


// display posts
Post::read();

// check if signed in 
require('../includes/new-post.php');

if (isset($_POST['btn'])) {

    // create post
    $post = new Post($_POST['post-body']);
    $post->create();

}
?>