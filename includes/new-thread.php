<?php if (isset($_SESSION['username'])) { ?>

<form action="" method="POST">
    <p>
    <input type="text" name="thread-title" maxlength="255">
    </p>
    <p>
    <input type="submit" name="btn" value="Create Thread">
    </p>
</form>

<?php } else {
    echo 'To create a thread, you must login or create an account!'; 
}   
?>