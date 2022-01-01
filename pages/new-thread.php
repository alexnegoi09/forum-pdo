<?php
require('../classes/Database.php'); 
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

if (!isset($_SESSION['username'])) {
    header('Location: /forum-pdo/index.php');
}

$thread = new Thread($db);

// check for valid id
$thread->categoryCheck();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New thread - My Forum</title>
</head>
<body>
    <h2>Start a new thread</h2>

    <form action="" method="POST">
        <p>
        <input type="text" name="thread-title" maxlength="255">
        </p>
        <p>
        <input type="submit" name="btn" value="Create Thread">
        </p>
    </form>
</body>
</html>


<?php

if (isset($_POST['btn'])) {
    // check for empty form
    $thread->emptyTitleCheck();

    // check for duplicate thread
    $thread->duplicateCheck();

    //create new thread
    if(empty($_SESSION['errors'])) {  
        $thread->create();
    } else {
        echo '<p>' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
    
} 

require('../includes/footer.php');
?>


