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
    <link rel="stylesheet" href="../css/delete-thread.css">
</head>
<body>
    
<?php
    require('../classes/Database.php');
    require('../includes/header.php');
    require('../includes/logout.php'); 
    require('../classes/Thread.php');


    if (isset($_SESSION['username'])) {

        if ($_SESSION['groups'] !== 'Administrator' && $_SESSION['groups'] !== 'Moderator')  {
            header('Location: /forum-pdo/index.php');

        } else {

        $thread = new Thread($_GET['category_id'], null, null, $db);
        $thread->categoryCheck();
        $thread->threadCheck();
        $thread->delete();
        echo '<p class="text-success">Thread deleted! Click <a href="/forum-pdo/pages/categories.php?id=' . $_GET['category_id'] . '">here</a> to go back.</p>';
        }
    }

?>

<script src="../js/user-color.js"></script> 
</body>
</html>