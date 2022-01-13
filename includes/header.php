<?php
ob_start();

session_start();


if (isset($_SESSION['username']) && isset($_SESSION['groups'])) { ?>

    <header class="main-header-user main-header">
            <h1 class="main-title"><a href="/forum-pdo/index.php">My Forum</a></h1>
            <div class="links">
                <?php echo '<div class="logged-in"><a href="/forum-pdo/pages/profile.php?user_id=' . $_SESSION['user_id'] . '" class="user-link">' . $_SESSION['username'] . '</a> (' . $_SESSION['groups'] . ')</div>'; ?>
                <div class="link-container">
                    <?php if ($_SESSION['groups'] === 'Administrator') { ?>
                        <a href="/forum-pdo/pages/cpanel.php" class="header-link">Admin Control Panel</a>
                    <?php } else if ($_SESSION['groups'] === 'Moderator') { ?>
                        <a href="/forum-pdo/pages/cpanel.php" class="header-link">Moderator Control Panel</a>
                    <?php } else { ?>
                        <a href="/forum-pdo/pages/cpanel.php" class="header-link">User Control Panel</a>
                    <?php } ?>
                    <a href="/forum-pdo/index.php?action=logout" class="header-link">Log out</a>
                </div>
            </div>
        </header>

    <?php } else { ?>

    <header class="main-header-guest main-header">
        <h1 class="main-title"><a href="/forum-pdo/index.php">My Forum</a></h1>
        <div class="links">
            <div class="logged-in">You are currently browsing the forum as a guest!</div>
            <div class="logged-in">You can <a href="/forum-pdo/pages/login.php">log in</a> or <a href="/forum-pdo/pages/signup.php">create a new account.</a></div>
        </div>
    </header>

<?php } ?>