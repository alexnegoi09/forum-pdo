<?php

class Login {
    public $username;
    public $password;
    public $db;

    public function __construct($user, $pass, $db) {
        $this->username = $user;
        $this->password = $pass;
        $this->db = $db;
    }


    public function validate() {
        // retrieve info from db

        session_start();

        $_SESSION['errors'] = [];

        $query = $this->db->prepare('SELECT userid, username, password, groups, email, joined, postcount, profilepic, location FROM users WHERE username = ?');
        $query->execute(array($this->username));
        $result = $query->fetch();
        
        // compare user input data to db data
        if(!$result || !password_verify($this->password, $result['password'])) {
            $_SESSION['errors'][] = 'The credentials you have entered are incorrect!';

            foreach ($_SESSION['errors'] as $err) {
                echo '<p>' . $err . '</p>'; 
            }

            $_SESSION['errors'] = null;

        } else {
            //save data and redirect
            $_SESSION['username'] = $result['username'];
            $_SESSION['groups'] = $result['groups'];
            $_SESSION['user_id'] = $result['userid'];
            $_SESSION['profilepic'] = $result['profilepic'];
            $_SESSION['postcount'] = $result['postcount'];
            $_SESSION['joined'] = $result['joined'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['location'] = $result['location'];

            $db = null;

            header('Location: ../index.php');

        }
    }


    public static function userProfileInfo($db) {
        try {
            $query = $db->prepare('SELECT username, groups, email, joined, postcount, profilepic, location FROM users WHERE userid = ?');
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

        $db = null;
    }

}

?>