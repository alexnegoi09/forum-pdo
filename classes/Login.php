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

            
            if (isset($_POST['checkbox'])) {
                $this->remember();
            }

            header('Location: ../index.php');

        }
    }


    public function remember() {
        try {
            $random = random_bytes(5);
            $rememberToken = $_SESSION['user_id'] . bin2hex($random);
            echo $rememberToken . '<br>';

            $stmt = $this->db->prepare('UPDATE users SET remember = ? WHERE userid = ?');
            $stmt->execute(array($rememberToken, $_SESSION['user_id']));
            setcookie('remember', $rememberToken, time() + 604800, '/');
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function stayLoggedIn() {

        try {
            $stmt = $this->db->prepare('SELECT * FROM users WHERE remember = ?');
            $stmt->execute(array($_COOKIE['remember']));
            $result = $stmt->fetch();

            if ($result) {
                $_SESSION['username'] = $result['username'];
                $_SESSION['groups'] = $result['groups'];
                $_SESSION['user_id'] = $result['userid'];
                $_SESSION['profilepic'] = $result['profilepic'];
                $_SESSION['postcount'] = $result['postcount'];
                $_SESSION['joined'] = $result['joined'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['location'] = $result['location'];

               // header('Location: /forum-pdo/index.php');
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } 
}

?>