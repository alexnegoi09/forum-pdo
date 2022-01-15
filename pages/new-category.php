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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New category - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/new-category.css">

</head>
<body>
    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>


    <form action="" method="POST" class="category-form">
        <h2 class="main-title-form">Create a new category</h2>
        <p>
            <label for="category-title" class="title-label">Title:</label>
            <input type="text" name="category-title" class="form-control" maxlength="255">
        </p>
        <p>
            <label for="category-description" class="description-label">Description:</label>
            <textarea name="category-description" cols="30" rows="5" class="form-control" maxlength="255"></textarea>
        </p>
        <p>
            <input type="submit" name="btn" value="Create category" class="btn btn-success">
        </p>
    </form>

    <script src="../js/user-color.js"></script> 
    <script src="../js/nav.js"></script>
</body>
</html>

<?php

if (isset($_POST['btn'])) {

    $category = new Category($_POST['category-title'], $_POST['category-description'], $db);

    // check for empty form
    $category->emptyFieldsCheck();

    // check for duplicate thread
    $category->duplicateCheck();

    //create new category
    if(empty($_SESSION['errors'])) {  
        $category->create();
    } else {
        foreach ($_SESSION['errors'] as $err) {
        echo '<p class="text-danger error">' . $err . '</p>';
        $_SESSION['errors'] = null;
        }
    }
    
} 

require('../includes/footer.php');
?>
