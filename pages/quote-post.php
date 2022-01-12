<?php
require('../classes/Database.php');
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Post.php');

$post_id = new Post($_GET['thread_id'], null, null, $db);

$post_id->messageCheck();

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote post - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <button class="back">Go back</button>

    <h2>Quote post</h2>

    <form action="" method="POST">
        <p>
            <textarea name="post-body" cols="30" rows="10">
                <?php echo '[quote][strong] On ' . $_SESSION['created_at'] . ' , ' . $_SESSION['post_author'] . ' wrote: [/strong][text]' . $_SESSION['post_body'] . '[/text][/quote]'; ?></textarea>
        </p>
        <p>
        <input type="submit" name="btn" value="Post">
        </p>
    </form>

    <script src="../js/nav.js"></script>
</body>
</html>


<?php 

if (isset($_POST['btn'])) {

    $post = new Post($_GET['thread_id'], $_POST['post-body'], $_SESSION['username'], $db);

    //check for empty message field
    $post->emptyMessageCheck();

    // edit and save
    if (empty($_SESSION['errors'])) { 
    $post->create();
    } else {

        // display errors
        echo '<p>' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');

?>