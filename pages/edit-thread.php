<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Thread.php');

$thread_id = new Thread(null, null, null, $db);

$thread_id->threadCheck();

if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit thread - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/edit-thread.css">
</head>
<body>
    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>


    <form action="" method="POST" class="thread-form">
        <h2 class="main-title-form">Edit thread</h2>
        <p>
            <label for="thread-title" class="thread-label">Title:</label>
            <input type="text" name="thread-title" class="form-control" maxlength="255" value="<?php echo $_SESSION['title']; ?>">
        </p>
        <p>
            <input type="submit" name="btn" class="btn btn-success" value="Edit thread">
        </p>
    </form>

    <script src="../js/user-color.js"></script>
    <script src="../js/nav.js"></script>
 </body>
 </html>

    <?php } else {  ?>

        <?php header('Location: /forum-pdo/index.php');  ?>

        <?php } ?>

<?php } ?>

<?php 

if (isset($_POST['btn'])) {

    $thread = new Thread($_GET['id'], $_POST['thread-title'], null, $db);

    //check for empty title field
    $thread->emptyTitleCheck();

    // edit and save
    if (empty($_SESSION['errors'])) { 
    $thread->update();

    header('Location: /forum-pdo/pages/categories.php?id=' . $_GET['category_id']);

    } else {

        // display errors
        echo '<p class="text-danger error">' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');
?>
