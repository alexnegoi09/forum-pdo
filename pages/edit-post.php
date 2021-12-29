<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

Post::messageCheck($db);

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

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post - My Forum</title>
</head>
<body>
    <h2>Edit post</h2>

    <form action="" method="POST">
        <p>
        <textarea name="post-body" cols="30" rows="10"><?php echo $_SESSION['post_body']; ?></textarea>
        </p>
        <p>
        <input type="submit" name="btn" value="Save">
        </p>
    </form>     
 </body>
 </html>


    <?php } else {  ?>

        <?php // header('Location: /forum-pdo/index.php');  ?>

        <?php } ?>

<?php } ?>

<?php 

if (isset($_POST['btn'])) {
    //check for empty message field
    Post::emptyMessageCheck();

    // edit and save
    if (empty($_SESSION['errors'])) { 
    $editedPost = new Post($_POST['post-body'], $db);
    $editedPost->update();
    } else {

        // display errors
        echo '<p>' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');
?>

