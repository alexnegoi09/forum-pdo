<?php 
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

// check for valid id
Post::threadPostCheck();

?>

<h2>Make a new post</h2>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10" name="message-body"></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Post">
    </p>
</form>


<?php

if (isset($_POST['btn'])) {
    //check for empty message field
    Post::emptyMessageCheck();

    // create post
    $post = new Post($_POST['post-body']);
    $post->create();

    // update postcount
    Post::updatePostCount();

}

?>