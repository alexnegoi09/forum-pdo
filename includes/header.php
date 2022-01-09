<?php
ob_start();

session_start();


if (isset($_SESSION['username']) && isset($_SESSION['groups'])) { ?> 

    <header>
        <h1><a href="/forum-pdo/index.php">My Forum</a></h1>
        <?php echo '<div>Logged in as: <a href="/forum-pdo/pages/profile.php?user_id=' . $_SESSION['user_id'] . '">' . $_SESSION['username'] . '</a> (' . $_SESSION['groups'] . ')</div>'; ?>
        <div>
            <?php if ($_SESSION['groups'] === 'Administrator') { ?>
                <a href="/forum-pdo/pages/cpanel.php">Administrator Control Panel</a>
            <?php } else if ($_SESSION['groups'] === 'Moderator') { ?>
                <a href="/forum-pdo/pages/cpanel.php">Moderator Control Panel</a>
            <?php } else { ?>
                <a href="/forum-pdo/pages/cpanel.php">User Control Panel</a>
            <?php } ?>
            <a href="/forum-pdo/index.php?action=logout">Log out</a>
        </div>
    </header>

<?php } else { ?>

    <header>
        <h1><a href="/forum-pdo/index.php">My Forum</a></h1>
        <div>You are currently browsing the forum as a guest!</div>
        <div>You can <a href="/forum-pdo/pages/login.php">log in</a> or <a href="/forum-pdo/pages/signup.php">create a new account.</a></div>
    </header>

<?php } ?>