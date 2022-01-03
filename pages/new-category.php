<?php
require('../classes/Database.php'); 
require('../includes/header.php');
require('../includes/logout.php'); 
require('../classes/Category.php');

if (isset($_SESSION['username'])) {
    if ($_SESSION['groups'] !== 'Administrator') {
    header('Location: /forum-pdo/index.php');
    }
}

$category = new Category($db);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New category - My Forum</title>
</head>
<body>
    <h2>Create a new category</h2>

    <form action="" method="POST">
        <p>
            <input type="text" name="category-title" maxlength="255" placeholder="Enter category title..">
        </p>
        <p>
            <input type="text" name="category-description" maxlength="255" placeholder="Enter category description..">
        </p>
        <p>
            <input type="submit" name="btn" value="Create Category">
        </p>
    </form>
</body>
</html>


<?php

if (isset($_POST['btn'])) {
    // check for empty form
    $category->emptyFieldsCheck();

    // check for duplicate thread
    $category->duplicateCheck();

    //create new category
    if(empty($_SESSION['errors'])) {  
        $category->create();
    } else {
        foreach ($_SESSION['errors'] as $err) {
        echo '<p>' . $err . '</p>';
        $_SESSION['errors'] = null;
        }
    }
    
} 

require('../includes/footer.php');
?>