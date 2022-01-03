<?php

class Post {
    public $db;


    public function __construct($db) {
        $this->db = $db;
    }


    public function create() {
        try {
            $stmt = $this->db->prepare('INSERT INTO posts (thread_id, body, author) VALUES (:thread_id, :body, :author)');
            $stmt->bindParam(':thread_id', $thread_id);
            $stmt->bindParam(':body', $body);
            $stmt->bindParam(':author', $author);

            $thread_id = $_GET['id'];
            $body = $_POST['post-body'];
            $author = $_SESSION['username'];

            $stmt->execute();
            
            

            header('Location: /forum-pdo/pages/threads.php?id=' . $_GET['id'] . '&page=' . $_GET['page']);


        } catch(PDOException $e) {
            echo $e->getMessage();
        }       
    }


    public function update() {
        try {
            $stmt = $this->db->prepare('UPDATE posts SET body = ? WHERE id = ?');
            $stmt->execute(array($_POST['post-body'], $_GET['id']));      
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        

        header('Location: /forum-pdo/pages/threads.php?id=' . $_GET['thread_id'] . '&page=' . $_GET['page']);
    }


    public function read() {

        // retrieve posts from db
        try {
            $stmt = $this->db->prepare('SELECT posts.id, posts.thread_id, posts.body, posts.author, posts.created_at, users.userid, users.groups 
                                   FROM posts INNER JOIN threads ON posts.thread_id = threads.id INNER JOIN users ON posts.author = users.username 
                                   WHERE threads.id = ? LIMIT ' . ($_GET['page'] * 10) - 10 . ', 10');
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
                                <p>Written by: <a href="/forum-pdo/pages/profile.php?user_id=' . $res['userid'] . '">' . $res['author'] . '</a> (' . $res['groups'] . ')</p>
                                <p>Posted on ' . $res['created_at'] . '</p>
                            </td>
                            <td>' .  $res['body'] .  '</td>
                          </tr>';

                          // if the user is an admin or a moderator, the edit and delete buttons remain on permanently, else, they disappear one hour after the message was posted

                          date_default_timezone_set('Europe/Bucharest');
                          if (isset($_SESSION['username'])) {
                            if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {
                                    echo '<tr>
                                            <td>
                                                <a href="/forum-pdo/pages/edit-post.php?id=' . $res['id'] . '&thread_id=' . $res['thread_id'] . '&page=' . $_GET['page'] . '">Edit</a>
                                                <a href="/forum-pdo/pages/delete-post.php?id=' . $res['id'] . '&thread_id=' . $res['thread_id'] . '&page=' . $_GET['page'] . '">Delete</a>
                                                <a href="/forum-pdo/pages/move-post.php?id=' . $res['id'] . '&thread_id=' . $res['thread_id'] . '&page=' . $_GET['page'] . '">Move</a>
                                            </td>
                                        </tr>'; 
                            } else if ($res['author'] === $_SESSION['username'] && time() < strtotime($res['created_at']) + 3600) {
                                echo '<tr>
                                          <td>
                                            <a href="/forum-pdo/pages/edit-post.php?id=' . $res['id'] . '&thread_id=' . $res['thread_id'] . '&page='. $_GET['page'] . '">Edit</a>
                                            <a href="/forum-pdo/pages/delete-post.php?id=' . $res['id'] . '&thread_id=' . $res['thread_id'] . '&page=' . $_GET['page'] . '">Delete</a>
                                          </td>
                                      </tr>';
                            }
                        }
                    
                }
                    echo '</table>';
            }


        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function threadPostCheck() {

        // check thread id
        try {
            $stmt = $this->db->prepare('SELECT * FROM threads WHERE id = ?');
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


    public function messageCheck() {

        try {
            $stmt = $this->db->prepare('SELECT * FROM posts WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            if (!$result) {
                header('Location: /forum-pdo/index.php');
                exit();

            }

            if ($_SESSION['groups'] !== 'Administrator' || $_SESSION['groups'] !== 'Moderator') {
                $_SESSION['post_author'] = $result['author'];
                $_SESSION['created_at'] = $result['created_at'];
                $_SESSION['post_body'] = $result['body'];
            } 
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    

    public function emptyMessageCheck() {
        $_SESSION['errors'] = [];

        if (empty($_POST['post-body'])) {
            $_SESSION['errors'][] = 'Please enter a message!';
        }
    }


    public function getPostCount() {

        //count user posts
        try {
            $stmt = $this->db->prepare('SELECT * FROM posts WHERE author = ?');
            $stmt->execute(array($_SESSION['username']));
            $result = $stmt->fetchAll();
            $number = count($result);
            $_SESSION['postcount'] = $number;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function setPostCount() {

         //update user postcount
         try {
            $stmt2 = $this->db->prepare("UPDATE users SET postcount = ? WHERE username = ?");
            $stmt2->execute(array($_SESSION['postcount'], $_SESSION['username']));
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function delete() {

        try {
            $stmt = $this->db->prepare('DELETE FROM posts WHERE id= ?');
            $stmt->execute(array($_GET['id']));
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }


    public function pagination() {

        try {
            $stmt = $this->db->prepare('SELECT * FROM posts WHERE thread_id= ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetchAll();

            // number of posts in the respective thread
            $numberOfPosts = count($result);

            // number of pages necessary to display posts (10 per page)
            $pages = ceil($numberOfPosts / 10);

            //prevent empty pages when posts <= 10
            if ($numberOfPosts <= 10 && $_GET['page'] > 1) {
                header('Location: /forum-pdo/pages/threads.php?id=' . $_GET['id'] . '&page=1'); 
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        if (!isset($_GET['page'])) {
            header('Location: /forum-pdo/index.php');
        } else if ($pages) {
                echo '<p>Pages:</p>';
                
                for ($i = 1; $i <= $pages; $i++) {
                   echo '<a href="/forum-pdo/pages/threads.php?id=' . $_GET['id'] . '&page=' . $i . '">' . $i . " " . '</a>';
                }
        }
    
    }


    public function getThreads() {
        try {
            $stmt = $this->db->query('SELECT * FROM threads');
            $stmt->execute();
            $result = $stmt->fetchAll();

            foreach($result as $res) {
                echo '<option>' . $res['title'] . ' / id: ' . $res['id'] . '</option>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function move() {
      
        $id = substr($_POST['select-thread'], strrpos($_POST['select-thread'], '/'));
    
        try {
            $stmt = $this->db->prepare('UPDATE posts SET thread_id = ? WHERE id = ?');
            $stmt->execute(array(filter_var($id, FILTER_SANITIZE_NUMBER_INT), $_GET['id']));
            echo 'The post has been successfully moved to the selected thread.';
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>