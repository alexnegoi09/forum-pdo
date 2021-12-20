<?php if (isset($_SESSION['username'])) { ?>

<form action="" method="POST">
    <p>
    <textarea name="post-body" cols="30" rows="10"></textarea>
    </p>
    <p>
    <input type="submit" name="btn" value="Post">
    </p>
</form>

<?php } else {

    echo 'To post a message, you must log in or create an account!'; 
}   
?>