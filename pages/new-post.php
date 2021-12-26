<?php 
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

if (!isset($_SESSION['username'])) {
    header('Location: /forum-pdo/index.php');
}

// check for valid id
Post::threadPostCheck();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum - New Post</title>
</head>
<body>
    <h2>Make a new post</h2>

    <form action="" method="POST">
        <p>
        <textarea name="post-body" cols="30" rows="10"></textarea>
        </p>
        <p>
        <input type="submit" name="btn" value="Post">
        </p>
    </form>
</body>
</html>


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