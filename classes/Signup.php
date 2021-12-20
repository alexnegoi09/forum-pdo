<?php

class Signup {
    public $username;
    public $password;
    public $repass;
    public $email;


    public function __construct($user, $pass, $repass, $email) {
        $this->username = $user;
        $this->password = $pass;
        $this->repass = $repass;
        $this->email = $email;

        // check for empty fields
        if (empty($user) || empty($pass) || empty($repass) || empty($email)) {
            exit('<p>Please complete all fields!</p>');
        }

        // check if username already exists
        require('../includes/database.php');
        $sql = "SELECT * FROM users WHERE username='" . $user . "'";
        if ($pdo->query($sql)->rowCount() != 0) {
            exit('<p>The username already exists! Please enter a different username.');
        }

        // check e-mail
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit('<p>Please enter a valid e-mail address!</p>');
        }

        // check password
        if (!password_verify($repass, $pass)) {
            exit('<p>The passwords do not match!</p>');
        }
        
        $pdo = null;
        
    }


    public function store() {
        // insert data into db
        require('../includes/database.php');
        $stmt = $pdo->prepare('INSERT INTO users(username, password, email, groups, postcount) VALUES (:username, :password, :email, :groups, :postcount)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':groups', $groups);
        $stmt->bindParam(':postcount', $postcount);

        $username = $this->username;
        $password = $this->password;
        $email = $this->email;
        $groups = 'Registered User';
        $postcount = 0;

        $stmt->execute();

        $pdo = null;

        echo '<p>Your account has been created successfully! You can now <a href="../pages/login.php">log in.</a></p>';

    }
    
}

?>