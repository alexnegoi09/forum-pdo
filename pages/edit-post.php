<?php
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {

        // check for valid id
        Post::messageCheck();
        
?>

<h2>Edit post</h2>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10" name="message-body"></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Edit message">
    </p>
</form>


   <?php } else if (time() < strtotime($res['created_at']) + 3600) {

       // check for valid id
       Post::messageCheck();
 ?>

<h2>Edit post</h2>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10" name="message-body"></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Edit message">
    </p>
</form>

    <?php } else {  ?>

        <?php // header('Location: /forum-pdo/index.php');  ?>

        <?php } ?>

<?php } ?>

