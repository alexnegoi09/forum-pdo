<?php
session_start();

if (isset($_SESSION['username'])) { ?> 

    <header>
        <div>
            <?php echo 'Welcome, <a href=/dev-php/forum-pdo/pages/profile.php>' . $_SESSION['username'] . '</a>!';?>
        </div>
        <div>
            <a href="/forum-pdo/index.php">Homepage</a>
            <a href="/forum-pdo/pages/cpanel.php">My Account</a>
            <a href="/forum-pdo/pages/members.php">Members</a>
            <a href="/forum-pdo/index.php?action=logout">Log out</a>
        </div>
    </header>

<?php } else { ?>

    <header>
        <div>Welcome, Guest!</div>
        <div>You can <a href="/forum-pdo/pages/login.php">log in</a> or <a href="/forum-pdo/pages/signup.php">create a new account!</a></div>
    </header>

<?php } ?>