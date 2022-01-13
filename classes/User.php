<?php

class User {
    public $username;
    public $password;
    public $repassword;
    public $email;
    public $profilepic;
    public $location;
    public $db;


    public function __construct($user, $pass, $repass, $email, $pic, $location, $db) {
        $this->username = $user;
        $this->password = $pass;
        $this->repass = $repass;
        $this->email = $email;
        $this->profilepic = $pic;
        $this->location = $location;
        $this->db = $db;
    }


    public function getProfileInfo() {
        try {
            $query = $this->db->prepare('SELECT username, groups, email, joined, postcount, profilepic, location FROM users WHERE userid = ?');
            $query->execute(array($_GET['user_id']));
            $result = $query->fetch();

            if (count($result) === 0) {
                header('Location: ../index.php');
            } else { ?>
                    
                <div class="user-info">
                    <h3 class="profile-title">User Profile - <span><?php echo $result['username']; ?></span></h3>
                    
                    <?php if ($result['profilepic']) { ?>
                        <p><span class="key">Profile picture:</span> <span class="value"><img src="<?php echo '/forum-pdo/img/' . $result['profilepic'] ?>" alt="profile picture"></span></p>
                    <?php } ?>    
                    <p><span class="key">E-mail:</span> <span class="value"><?php echo $result['email']; ?></span></p>
                    <p><span class="key">Join date:</span> <span class="value"><?php echo $result['joined']; ?></span></p>
                    <p><span class="key">Rank:</span> <span class="value"><?php echo $result['groups']; ?></span></p>
                    <p><span class="key">Number of posts:</span> <span class="value"><?php echo $result['postcount']; ?></span></p>
                    <p><span class="key">Location:</span> <span class="value"><?php echo $result['location']; ?></span></p>
                </div>
            <?php } ?>
       <?php } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getPageTitle() {
        switch($_SESSION['groups']) {
            case 'Administrator':
                echo '<h3>Administrator Control Panel</h3>';
                break;
            
            case 'Moderator':
                echo '<h3>Moderator Control Panel</h3>';
                break;

            default:
                echo '<h3>User Control Panel</h3>';
        }
    }
    

    public function updatePassword() {
        $_SESSION['errors'] = [];

        if (!empty($this->password) && !empty($this->repass)) {
            if (empty($this->password) && !empty($this->repass)  || !empty($this->password) && empty($this->repass) || $_POST['password'] !== $this->repass) {
            array_push($_SESSION['errors'], 'The passwords do not match!');
        } else {
            try {
                $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE username = ?');
                $stmt->execute(array(password_hash($this->password, PASSWORD_DEFAULT), $this->username));
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}


    public function updateProfilePic() {
        if ($_FILES['profilepic']['type'] === "image/jpeg" && $_FILES['profilepic']['type'] = 'image/png' && $_FILES['profilepic']['size'] < 2097152) {

                // check image size
            $image_info = getimagesize($_FILES['profilepic']['tmp_name']);
    
            if ($image_info[0] > 200 && $image_info[1] > 200) {
                array_push($_SESSION['errors'], 'The maximum picture resolution must be 200x200!');
                 
                // if resolution is ok, upload image path to db
            } else if (move_uploaded_file($_FILES['profilepic']['tmp_name'], '../img/' . $_FILES['profilepic']['name'])) {
    
                try {
                    $stmt = $this->db->prepare('UPDATE users SET profilepic = ? WHERE username = ?');
                    $stmt->execute(array($this->profilepic, $this->username));
                    $_SESSION['profilepic'] = $this->profilepic;
                } catch(PDOException $e) {
                    echo $e->getMessage();
                }
            }
        } else {
            array_push($_SESSION['errors'], "The maximum filesize must be 2 MB! The supported file extensions are '.jpg', '.jpeg' or '.png'!");
        }
    }
    
    
    public function deleteProfilePic() {
        try {
            $stmt = $this->db->prepare('UPDATE users SET profilepic = ? WHERE username = ?');
            $stmt->execute(array('', $this->username));
            header('Location: /forum-pdo/pages/cpanel.php');
        } catch(PDOException $e) {
           echo $e->getMessage();
        }

        $_SESSION['profilepic'] = null;
    }


    public function updateEmail() {
       
        try {
            $stmt = $this->db->prepare('UPDATE users SET email = ? WHERE username = ?');
            $stmt->execute(array($this->email, $this->username));
            $_SESSION['email'] = $this->email;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function updateLocation() {
        try {
            $stmt = $this->db->prepare('UPDATE users SET location = ? WHERE username = ?');
            $stmt->execute(array($this->location, $this->username));
            $_SESSION['location'] = $this->location;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getUsers() {
        try {
            $stmt = $this->db->prepare('SELECT username FROM users WHERE groups = ?');
            $stmt->execute(array('Registered User'));
            $result = $stmt->fetchAll();
            
            foreach($result as $res) {
                echo '<option>' . $res['username'] . '</option>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getWarnings() {
        if ($_POST['users'] !== 'Select a user') {
            try {
                $stmt = $this->db->prepare('SELECT warnings FROM users WHERE username = ?');
                $stmt->execute(array($_POST['users']));
                $result = $stmt->fetch();

                echo '<p>Number of warnings: ' . $result['warnings'] . '</p>';
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function setWarnings() {
        if ($_POST['warn'] !== 'Select a user') {
            try {
                $stmt = $this->db->prepare('UPDATE users SET warnings = warnings + 1 WHERE username = ?');
                $stmt->execute(array($_POST['warn']));

                echo '<p>The warning has been set!</p>';
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function getThreads() {
        try {
            $stmt = $this->db->query('SELECT title FROM threads');
            $stmt->execute();
            $result = $stmt->fetchAll();
            
            foreach($result as $res) {
                echo '<option>' . $res['title'] . '</option>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function lockThread() {
        if ($_POST['lock'] !== 'Select a thread') {
            try {
                $stmt = $this->db->prepare('UPDATE threads SET locked = ? WHERE title = ?');
                $stmt->execute(array(1, $_POST['lock']));
                echo '<p>The selected thread has been locked!</p>';
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function unlockThread() {
        if ($_POST['lock'] !== 'Select a thread') {
            try {
                $stmt = $this->db->prepare('UPDATE threads SET locked = ? WHERE title = ?');
                $stmt->execute(array(0, $_POST['lock']));
                echo '<p>The selected thread has been unlocked!</p>';
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


    public function banUser() {
        if ($_POST['ban'] !== 'Select a user') {
            try {
                $stmt = $this->db->prepare('DELETE FROM users WHERE username = ?');
                $stmt->execute(array($_POST['ban']));
                echo '<p>The selected user has been banned!</p>';
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
?>