<?php

class Thread {
    public $title;


    public function __construct($title) {
        $this->title = $title;
    }


    public function create() {
        require('../includes/database.php');

        try {
            $stmt = $pdo->prepare('INSERT INTO threads(category_id, title, author) VALUES (:category_id, :title, :author)');
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':title', $thread_title);
            $stmt->bindParam(':author', $thread_author);

            $category_id = $_GET['id'];
            $thread_title = $this->title;
            $thread_author = $_SESSION['username'];

            $stmt->execute();
            echo '<p>Thread has been successfully created!</p>';
            $pdo = null;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function categoryCheck() {
        require('../includes/database.php');

        // check category id
        try {
            $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();
            if (!$result) {
                header('Location: /forum-pdo/index.php');
                exit();

                $pdo = null;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function emptyTitleCheck() {
        if (empty($_POST['thread-title'])) {
            exit('Please enter a thread title!');
        }
    }


    public static function duplicateCheck() {
        require('../includes/database.php');

        // check for duplicate threads
        try {
            $stmt = $pdo->prepare('SELECT * FROM threads WHERE title = ?');
            $stmt->execute(array($_POST['thread-title']));
            $result = $stmt->fetchAll();
            if ($result) {
                exit('There is already a thread with the same name!');
            }
            

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function read() {
        require('../includes/database.php');

        // retrieve threads from db
        try {
            $stmt = $pdo->prepare('SELECT threads.id, threads.title, threads.author, threads.created_at 
                                   FROM threads INNER JOIN categories ON threads.category_id = categories.id 
                                   WHERE categories.id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetchAll();

            if (count($result) === 0) {
                echo'<p>There are no threads to show!</p>';
            } else {

                // display threads
                echo '<table>
                    <tr>
                        <td>Threads</td>
                    </tr>
                    <tr>
                        <td>Title</td>
                        <td>Created on</td>
                        <td>Created by</td>
                    </tr>';

                foreach ($result as $res) {
                    echo '<tr>
                            <td><a href=/forum-pdo/pages/threads.php?id=' . $res['id'] . '>' . $res['title'] . '</td>
                            <td>' . $res['created_at'] . '</td>
                            <td>' . $res['author'] . '</td>
                          </tr>';
                }
                echo '</table>';
            }

            $pdo = null;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>