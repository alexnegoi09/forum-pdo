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

        $query = $pdo->prepare('SELECT username, password FROM users WHERE username = ?');
        $query->execute(array($this->username));
        $result = $query->fetch();
        
        // compare user input data to db data
        if(!$result || !password_verify($this->password, $result['password'])) {
            exit('<p>The credentials you have entered are incorrect!</p>');

        } else {
            //save data and redirect
            session_start();
            $_SESSION['username'] = $result['username'];

            $pdo = null;

            header('Location: ../index.php');

        }
    }

}

?>