<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

$post = new Post($_GET['id'], null, null, $db);


if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Move post - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/move-post.css">
</head>
<body>
    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>


    <form action="" method="POST" class="post-form">
        <h2 class="main-title-form">Move post</h2>
        <p>
            <label for="select-thread" class="select-label">Select thread to move post to:</label>
            <select name="select-thread" class="select-thread form-select">
            <?php 
                $post->getThreads();
            ?>
            </select>
        </p>
        <p>
            <input type="submit" name="btn" value="Move post" class="btn btn-success">
        </p>
</form>

        <?php if (isset($_POST['btn'])) {
            $post->move();
        } ?>

    <?php } ?>

<?php } ?>

<?php
require('../includes/footer.php');
?>

    <script src="../js/user-color.js"></script>
    <script src="../js/nav.js"></script>
</body>
</html>