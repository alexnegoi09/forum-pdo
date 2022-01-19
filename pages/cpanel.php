<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Control Panel - My Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/cpanel.css">
</head>
<body>
    <?php
    require('../includes/header.php');
    require('../includes/logout.php');
    require('../classes/Database.php');
    require('../classes/User.php'); 

    if (!isset($_SESSION['username'])) {
        header('Location: /forum-pdo/index.php');
    }

    ?>

    <nav class="nav">
        <button class="back btn btn-outline-dark">Go back</button>
    </nav>

    <div class="main-container">
        <form action="" method="POST" enctype="multipart/form-data" class="cpanel-form">
            <?php $user = new User(null, null, null, null, null, null, $db); ?>

            <h3 class="main-title-form">User Controls</h3>

            <p>
                <?php if (empty($_SESSION['profilepic'])) { ?>
                    <label for="profilepic" class="cpanel-label">Change profile picture:</label>
                    <input type="file" name="profilepic" class="form-control">
                    <small>The picture must have a maximum resolution of 200x200, and be 2 MB in size!</small>
                <?php } else { ?>
                    <p>Profile Picture:</p>
                    <img src="<?php echo '../img/' . $_SESSION['profilepic']; ?>" alt="profile picture">
                    <input type="submit" name="remove" value="Remove" class="btn btn-dark">
                <?php } ?>
            </p>
            <p>
                <label for="username" class="cpanel-label">Username: </label>
                <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" class="form-control" disabled>
            </p>
            <p>
                <label for="password" class="cpanel-label">New password: </label>
                <input type="password" name="password" class="form-control">
            </p>
            <p>
                <label for="repass" class="cpanel-label">Re-type password: </label>
                <input type="password" name="repass" class="form-control">
            </p>
            <p>
                <label for="location" class="cpanel-label">E-mail: </label>
                <input type="text" name="email" value="<?php echo $_SESSION['email']; ?>" class="form-control">
            </p>
            <p>
                <label for="location" class="cpanel-label">Location: </label>
                <input type="text" name="location" value="<?php echo $_SESSION['location']; ?>" class="form-control">
            </p>
            <p>
                <input type="submit" name="update" value="Update info" class="btn btn-success">
            </p>
        </form>

    

        <?php if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') { ?>


        <form action="" method="POST" class="cpanel-form">
            <h3 class="main-title-form">Forum Controls</h3>
            <p>
                <label for="users" class="cpanel-label">Get user warnings: </label>
                <select name="users" class="form-select">
                    <option>Select a user</option>
                    <?php 
                        $admin = new User(null, null, null, null, null, null, $db);
                        $admin->getUsers();
                    ?>
                </select>
            </p>
            <p>
                <input type="submit" name="get-warnings-btn" value="Get warnings" class="btn btn-primary">
            </p>

            <?php 
                if (isset($_POST['get-warnings-btn'])) {
                    $admin->getWarnings();
                } 
            ?>

            <p>
                <label for="warn" class="cpanel-label">Warn user: </label>
                <select name="warn" class="form-select">
                    <option>Select a user</option>
                    <?php $admin->getUsers(); ?>
                </select>
            </p>
            <p>
                <input type="submit" name="set-warnings-btn" value="Warn" class="btn btn-primary">
            </p>

            <?php 
                if (isset($_POST['set-warnings-btn'])) {
                    $admin->setWarnings();
                }                                                   
            ?>

            <p>
                <label for="lock" class="cpanel-label">Lock or unlock a thread: </label>
                <select name="lock" class="form-select">
                    <option>Select a thread</option>
                    <?php $admin->getThreads(); ?>
                </select>
            </p>
            <p>
                <input type="submit" name="lock-thread-btn" value="Lock" class="btn btn-primary">
                <input type="submit" name="unlock-thread-btn" value="Unlock" class="btn btn-primary">
            </p>

            <?php
                if (isset($_POST['lock-thread-btn'])) {
                    $admin->lockThread();
                }

                if (isset($_POST['unlock-thread-btn'])) {
                    $admin->unlockThread();
                }
            ?>
            

            <?php if ($_SESSION['groups'] === 'Administrator') { ?>

            <p>
                <label for="ban" class="cpanel-label">Ban user: </label>
                <select name="ban" class="form-select">
                    <option>Select a user</option>
                    <?php $admin->getUsers(); ?>
                </select>
            </p>
            <p>
                <input type="submit" name="ban-btn" value="Ban" class="btn btn-danger">
            </p>

            <?php 
                if (isset($_POST['ban-btn'])) {
                    $admin->banUser();
                }
                
            ?>
                <?php } ?>
            <?php } ?>
        </form>
    </div>

    <?php 
        if (isset($_POST['update'])) {
            if (isset($_FILES['profilepic']['name'])) {
                $user = new User($_SESSION['username'], $_POST['password'], $_POST['repass'], $_POST['email'], $_FILES['profilepic']['name'], $_POST['location'], $db);
            } else {
                $user = new User($_SESSION['username'], $_POST['password'], $_POST['repass'], $_POST['email'], null, $_POST['location'], $db);
            }
            
            $user->updatePassword();

            if (empty($_FILES['profilepic']['name'])) {
                $_FILES['profilepic'] = null;
            } else {
                $user->updateProfilePic();
            }
            $user->updateEmail();
            $user->updateLocation();

            if (!empty($_SESSION['errors'])) {
                foreach($_SESSION['errors'] as $err) {
                    echo '<p class="text-danger error">' . $err . '</p>';
                }
            } else {
                echo '<p class="text-success success">Your user info has been updated!</p>';
            }
        }

        if (isset($_POST['remove'])) {
            $user_remove = new User($_SESSION['username'], null, null, null, null, null, $db);
            $user_remove->deleteProfilePic();
        }

    ?>


    <?php require('../includes/footer.php'); ?>

    <script src="../js/user-color.js"></script>
    <script src="../js/nav.js"></script>
</body>
</html>