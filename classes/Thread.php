<?php

class Thread {
    public $db;


    public function __construct($db) {
        $this->db = $db;
    }


    public function create() {

        try {
            $stmt = $this->db->prepare('INSERT INTO threads(category_id, title, author) VALUES (:category_id, :title, :author)');
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':title', $thread_title);
            $stmt->bindParam(':author', $thread_author);

            $category_id = $_GET['id'];
            $thread_title = $_POST['thread-title'];
            $thread_author = $_SESSION['username'];

            $stmt->execute();
            echo '<p>Thread has been successfully created! Click <a href="/forum-pdo/pages/categories.php?id=' . $_GET['id'] . '">here</a> to go back.</p>';
            $db = null;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function categoryCheck() {

        $_SESSION['errors'] = [];

        // check category id
        try {
            $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();
            if (!$result) {
                header('Location: /forum-pdo/index.php');
                exit();

            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function emptyTitleCheck() {
        if (empty($_POST['thread-title'])) {
            $_SESSION['errors'][] = 'Please enter a thread title!';
        }
    }


    public function duplicateCheck() {

        // check for duplicate threads
        try {
            $stmt = $this->db->prepare('SELECT * FROM threads WHERE title = ?');
            $stmt->execute(array($_POST['thread-title']));
            $result = $stmt->fetchAll();
            if ($result) {
                $_SESSION['errors'][] = 'There is already a thread with the same name!';
            }
            

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function read() {

        // retrieve threads from db
        try {
            $stmt = $this->db->prepare('SELECT threads.id, threads.title, threads.author, threads.created_at 
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
                            <td><a href=/forum-pdo/pages/threads.php?id=' . $res['id'] . '&page=1>' . $res['title'] . '</td>
                            <td>' . $res['created_at'] . '</td>
                            <td>' . $res['author'] . '</td>
                          </tr>';
                }
                echo '</table>';
            }

            $db = null;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getTitle() {
    
        try {
            $stmt = $this->db->prepare('SELECT title FROM threads WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            return '<a href="/forum-pdo/pages/threads.php?id=' . $_GET['id'] .  '&page=1">' . $result['title'] . '</a>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        $pdo = null;
    }


    public function getPageTitle() {

        try {
            $stmt = $this->db->prepare('SELECT title FROM threads WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            echo $result['title'] . ' - My Forum';
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        $db = null;
    }
}

?>