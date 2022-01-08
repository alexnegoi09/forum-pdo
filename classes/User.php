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

                <h3>User Profile - <?php echo $result['username']; ?></h3>
                    
                <div>
                    <p>Statistics</p>
                    <p>Profile picture: <?php echo $result['profilepic']; ?></p>
                    <p>E-mail: <?php echo $result['email']; ?></p>
                    <p>Join date: <?php echo $result['joined']; ?></p>
                    <p>Rank: <?php echo $result['groups']; ?></p>
                    <p>Number of posts: <?php echo $result['postcount']; ?></p>
                    <p>Location: <?php echo $result['location']; ?></p>
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

        if (empty($this->password) || empty($this->repass)  || $_POST['password'] !== $this->repass) {
            array_push($_SESSION['errors'], 'The passwords do not match!');
        } else {
            try {
                $stmt = $this->db->prepare('UPDATE users SET password = ? WHERE username = ?');
                $stmt->execute(array($this->password, $this->username));
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    
}

?>