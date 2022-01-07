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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit category - My Forum</title>
</head>
<body>
    <button class="back">Go back</button>

    <h2>Edit category</h2>

    <form action="" method="POST">
        <p>
            <input type="text" name="category-title" maxlength="255" placeholder="Enter category title.." value="<?php echo $_SESSION['name']; ?>">
        </p>
        <p>
            <textarea name="category-description" cols="30" rows="10" maxlength="255" placeholder="Enter category description.."><?php echo $_SESSION['description']; ?></textarea>
        </p>
        <p>
            <input type="submit" name="btn" value="Edit Category">
        </p>
    </form>

    <script src="../js/nav.js"></script>
 </body>
 </html>

    <?php } else {  ?>

        <?php header('Location: /forum-pdo/index.php');  ?>

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
        echo '<p>' . $_SESSION['errors'][0] . '</p>';
        $_SESSION['errors'] = null;
    }
}

require('../includes/footer.php');

?>
