<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        require('../classes/Database.php');
        require('../classes/Category.php'); 
        $category = new Category(null, null, $db); 
        $category->getPageTitle(); 
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer-main.css">
    <link rel="stylesheet" href="../css/categories.css">
</head>
<body>
    <?php
    require('../classes/Thread.php'); 
    require('../classes/Navigation.php');
    require('../includes/header.php');
    require('../includes/logout.php'); 

    // check for valid id
    $thread = new Thread($_GET['id'], null, null, $db);
    $thread->categoryCheck();
    ?>

    <div class="main-container">
    
        <?php
        // display forum navigation
        $nav = new Navigation($db);
        $nav->display();

        // display category title
        echo '<h3 class="category-title"><p>Category: <strong>' . $category->getTitle() . '</strong></p></h3>';


        // retrieve and display threads from db
        $thread->read();

        $db = null;

        // check if signed in
        require('../includes/thread-link.php');

        ?>
    </div>

    <?php require('../includes/footer.php'); ?>
    
    <script src="../js/user-color.js"></script>
</body>
</html>

