<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/delete-post.css">
</head>
<body>

<?php
    require('../classes/Database.php');
    require('../includes/header.php');
    require('../includes/logout.php'); 
    require('../classes/Post.php');

    if (isset($_SESSION['username'])) {
        $post = new Post($_GET['id'], null, null, $db);


        $post->messageCheck();

        if ($_SESSION['post_author'] === $_SESSION['username'] && time() < strtotime($_SESSION['created_at']) + 3600) {
            $post->delete();
            $post->getPostCount();
            $post->setPostCount();
            echo '<p class="text-success">Your message has been deleted! Click <a href="/forum-pdo/pages/threads.php?id=' . $_GET['thread_id'] . '&page=' . $_GET['page'] . '">here</a> to go back to the thread.</p>';
        } else if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {
            $post->delete();
            $post->getPostCount();
            $post->setPostCount();
            echo '<p class="text-success">Message deleted! Click <a href="/forum-pdo/pages/threads.php?id=' . $_GET['thread_id'] . '&page=' . $_GET['page'] . '">here</a> to go back to the thread.</p>';
            }
        } else {
            header('Location: /forum-pdo/index.php');
        }

?>

    <script src="../js/user-color.js"></script>
</body>
</html>



