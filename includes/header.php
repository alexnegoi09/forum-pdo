<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['groups'])) { ?> 

    <header>
        <?php echo '<div>Welcome, <a href="/forum-pdo/pages/profile.php">' . $_SESSION['username'] . '</a>! (' . $_SESSION['groups'] . ')</div>'; ?>
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