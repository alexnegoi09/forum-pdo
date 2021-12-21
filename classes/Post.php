<?php

class Post {
    public $message;


    public function __construct($message) {
        $this->message = $message;
    }


    public function create() {
        require('../includes/database.php');

        try {
            $stmt = $pdo->prepare('INSERT INTO posts(thread_id, body, author) VALUES (:thread_id, :body, :author)');
            $stmt->bindParam(':thread_id', $thread_id);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':author', $author);

            $thread_id = $_GET['id'];
            $body = $this->message;
            $author = $_SESSION['username'];

            $stmt->execute();
            
            $pdo = null;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        
    }


    public static function read() {
        require('../includes/database.php');

        // retrieve posts from db
        try {
            $stmt = $pdo->prepare('SELECT posts.id, posts.body, posts.author, posts.created_at, users.groups 
                                   FROM posts INNER JOIN threads ON posts.thread_id = threads.id INNER JOIN users ON posts.author = users.username 
                                   WHERE threads.id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetchAll();
            
            if (count($result) === 0) {
                echo '<p>There are no posts to show!</p>';
            } else {
                // show posts
                echo '<table>
                        <tr>
                            <td>Posts</td>
                        </tr>';

                foreach($result as $res) {
                    echo '<tr>
                            <td>
                                <p>Written by: <a href="/forum-pdo/pages/profile.php">' . $res['author'] . '</a> (' . $res['groups'] . ')</p>
                                <p>Posted on ' . $res['created_at'] . '</p>
                            </td>
                            <td>' .  $res['body'] .  '</td>
                          </tr>';
                          if (isset($_SESSION['username'])) {
                            if ($_SESSION['username'] === $res['author']) {
                                echo '<tr>
                                        <td><input type="submit" value="Delete Post"></td>
                                    </tr>';
                          }
                        }
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