<?php

class Login {
    public $username;
    public $password;

    public function __construct($user, $pass) {
        $this->username = $user;
        $this->password = $pass;

        // check for empty fields
        if (empty($user) || empty($pass)) {
            exit('<p>Please enter a username and password!</p>');
        }
    }


    public function validate() {
        // retrieve info from db
        require('../includes/database.php');

        session_start();

        $_SESSION['errors'] = [];

        $query = $pdo->prepare('SELECT id, username, password, groups, email, joined, postcount, profilepic, location FROM users WHERE username = ?');
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
            $_SESSION['user-id'] = $result['id'];
            $_SESSION['profilepic'] = $result['profilepic'];
            $_SESSION['postcount'] = $result['postcount'];
            $_SESSION['joined'] = $result['joined'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['location'] = $result['location'];

            $pdo = null;

            header('Location: ../index.php');

        }
    }

}

?>