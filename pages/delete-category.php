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
    <link rel="stylesheet" href="../css/delete-category.css">
</head>
<body>

<?php
    require('../classes/Database.php');
    require('../includes/header.php');
    require('../includes/logout.php'); 
    require('../classes/Category.php');


    if (isset($_SESSION['username'])) {

        if ($_SESSION['groups'] !== 'Administrator') {
            header('Location: /forum-pdo/index.php');

        } else {

        $category = new Category(null, null, $db);
        $category->categoryCheck();
        $category->delete();
        echo '<p class="text-success">Category deleted! Click <a href="/forum-pdo/index.php">here</a> to go back.</p>';
        }
    }   

?>

    <script src="../js/user-color.js"></script> 
</body>
</html>
