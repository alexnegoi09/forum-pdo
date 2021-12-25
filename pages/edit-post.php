<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

Post::messageCheck();

if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {

        
?>

<h2>Edit post</h2>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10"><?php echo $_SESSION['post_body']; ?></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Save">
    </p>
</form>


   <?php } else if ($_SESSION['post_author'] === $_SESSION['username'] && time() < strtotime($_SESSION['created_at']) + 3600) {

       // check for valid id
 ?>

<h2>Edit post</h2>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10"><?php echo $_SESSION['post_body']; ?></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Save">
    </p>
</form>

    <?php } else {  ?>

        <?php // header('Location: /forum-pdo/index.php');  ?>

        <?php } ?>

<?php } ?>

<?php 

if (isset($_POST['btn'])) {
    //check for empty message field
    Post::emptyMessageCheck();

    // edit and save 
    $editedPost = new Post($_POST['post-body']);
    $editedPost->update();
}

?>

