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
        $this->repassword = $repass;
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
}

?>