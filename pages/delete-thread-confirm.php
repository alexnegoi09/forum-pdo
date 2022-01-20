<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/delete-thread-confirm.css">
</head>
<body>
    <?php
        require('../includes/header.php');
        require('../includes/logout.php'); 
    ?>
    <div class="message-container">
        <div class="message-box">
            <p>Are you sure you want to delete this thread?<br> <span class="text-danger">This action cannot be undone!</span></p>
        </div>
        <div class="buttons">
            <a href="<?php echo '/forum-pdo/pages/delete-thread.php?id=' . $_GET['id'] . '&category_id=' . $_GET['category_id']; ?>" class="btn btn-primary">Yes</a>
            <a href="<?php echo '/forum-pdo/pages/categories.php?id=' . $_GET['category_id']; ?>" class="btn btn-primary">No</a>
        </div>
    </div>
    
    <?php require('../includes/footer.php');?>

    <script src="../js/user-color.js"></script>
</body>
</html>