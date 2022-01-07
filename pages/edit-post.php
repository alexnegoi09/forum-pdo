<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

$post_id = new Post($_GET['id'], null, null, $db);

$post_id->messageCheck();

if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator' || $_SESSION['post_author'] === $_SESSION['username'] && time() < strtotime($_SESSION['created_at']) + 3600) {

        
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
    <button class="back">Go back</button>

    <h2>Edit post</h2>

    <form action="" method="POST">
        <p>
        <textarea name="post-body" cols="30" rows="10"><?php echo $_SESSION['post_body']; ?></textarea>
        </p>
        <p>
        <input type="submit" name="btn" value="Save">
        </p>
    </form>

    <script src="../js/nav.js"></script>
</body>
</html>

    <?php } else {
        header('Location: /forum-pdo/index.php');
    } ?>

<?php } ?>

<?php 

if (isset($_POST['btn'])) {

    $post = new Post($_GET['id'], $_POST['post-body'], $_SESSION['username'], $db);

    //check for empty message field
    $post->emptyMessageCheck();

    // edit and save
    if (empty($_SESSION['errors'])) { 
    $post->update();
    } else {

        // display errors
        echo '<p>' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');

?>
