<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New thread - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/new-thread.css">
</head>
<body>
    <?php
    require('../classes/Database.php'); 
    require('../includes/header.php');
    require('../includes/logout.php'); 
    require('../classes/Thread.php');

    if (!isset($_SESSION['username'])) {
        header('Location: /forum-pdo/index.php');
        exit();
    }

    $thread_id = new Thread($_GET['id'], null, null, $db);

    // check for valid id
    $thread_id->categoryCheck();
    ?>

    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>


    <form action="" method="POST" class="thread-form">
        <h2 class="main-title-form">Start a new thread</h2>
        <p>
            <label for="thread-title" class="thread-label">Title:</label>        
            <input type="text" name="thread-title" class="form-control" maxlength="255">
        </p>
        <p>
            <input type="submit" name="btn" value="Create thread" class="btn btn-success">
        </p>
    </form>

    <?php

    if (isset($_POST['btn'])) {

        $thread = new Thread($_GET['id'], $_POST['thread-title'], $_SESSION['username'], $db);

        // check for empty form
        $thread->emptyTitleCheck();

        // check for duplicate thread
        $thread->duplicateCheck();

        //create new thread
        if(empty($_SESSION['errors'])) {  
            $thread->create();
        } else {
            echo '<p class="text-danger error">' . $_SESSION['errors'][0] . '</p>';
            $_SESSION['errors'] = null;
        }
    
    } 

    require('../includes/footer.php');
    ?>

    <script src="../js/user-color.js"></script>
    <script src="../js/nav.js"></script>
</body>
</html>
