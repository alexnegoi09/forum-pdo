<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit category - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/new-category.css">
</head>
<body>
    <?php   
    require('../classes/Database.php');
    require('../includes/header.php');
    require('../includes/logout.php'); 
    require('../classes/Category.php');

    $category_id = new Category(null, null, $db);

    $category_id->categoryCheck();

    if (isset($_SESSION['username'])) {
        if ($_SESSION['groups'] === 'Administrator') {        
    ?>

    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>


    <form action="" method="POST" class="category-form">
        <h2 class="main-title-form">Edit category</h2>
        <p>
            <label for="title-label">Title:</label>
            <input type="text" name="category-title" maxlength="255" value="<?php echo $_SESSION['name']; ?>" class="form-control">
        </p>
        <p>
            <label for="description-label">Description:</label>
            <textarea name="category-description" cols="30" rows="5" maxlength="255" class="form-control"><?php echo $_SESSION['description']; ?></textarea>
        </p>
        <p>
            <input type="submit" name="btn" value="Edit category" class="btn btn-success">
        </p>
    </form>

    <?php } else {  ?>

    <?php header('Location: /forum-pdo/index.php');
    exit();  
    ?>

    <?php } ?>

<?php } ?>

    <?php 

    if (isset($_POST['btn'])) {

    $category = new Category($_POST['category-title'], $_POST['category-description'], $db);

    //check for empty message field
    $category->emptyFieldsCheck();

    // edit and save
    if (empty($_SESSION['errors'])) { 
        $category->update();

    header('Location: /forum-pdo/index.php');

    } else {

        // display errors
        echo '<p class="error text-danger">' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
        }
    }

    require('../includes/footer.php');

    ?>

    <script src="../js/user-color.js"></script> 
    <script src="../js/nav.js"></script>
 </body>
 </html>

    
