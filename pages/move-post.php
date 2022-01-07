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
</head>
<body>
<button class="back">Go back</button>

<h2>Move post</h2>

<form action="" method="POST">
    <p>
        <select name="select-thread">
            <?php 
                $post->getThreads();
            ?>
        </select>
    </p>
    <p>
        <input type="submit" name="btn" value="Move post">
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

    <script src="../js/nav.js"></script>
</body>
</html>