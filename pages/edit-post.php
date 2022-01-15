<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

$post_id = new Post($_GET['thread_id'], null, null, $db);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/edit-post.css">
</head>
<body>
    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>

    <form action="" method="POST" class="post-form">
        <h2 class="main-title-form">Edit post</h2>
        <p>
            <textarea name="post-body" cols="30" rows="7" class="form-control"><?php echo $_SESSION['post_body']; ?></textarea>
        </p>
        <p>
            <input type="submit" name="btn" value="Save edit" class="btn btn-success">
        </p>
    </form>

    <script src="../js/user-color.js"></script>
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
        echo '<p class="text-danger error">' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');

?>
