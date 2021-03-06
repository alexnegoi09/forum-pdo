<?php

class Thread {
    private $category_id;
    private $title;
    private $author;
    private $db;


    public function __construct($category_id, $title, $author, $db) {
        $this->category_id = $category_id;
        $this->title = $title;
        $this->author = $author;
        $this->db = $db;
    }


    public function create() {

        try {
            $stmt = $this->db->prepare('INSERT INTO threads(category_id, title, author) VALUES (:category_id, :title, :author)');
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':title', $thread_title);
            $stmt->bindParam(':author', $thread_author);

            $category_id = $this->category_id;
            $thread_title = $this->title;
            $thread_author = $this->author;

            $stmt->execute();
            echo '<p class="text-success success">Thread has been successfully created! Click <a href="/forum-pdo/pages/categories.php?id=' . $_GET['id'] . '" class="text-dark">here</a> to go back.</p>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function categoryCheck() {

        $_SESSION['errors'] = [];

        // check category id
        try {
            $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
            $stmt->execute(array($this->category_id));
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
        if (empty($this->title)) {
            $_SESSION['errors'][] = 'Please enter a thread title!';
        }
    }


    public function duplicateCheck() {

        // check for duplicate threads
        try {
            $stmt = $this->db->prepare('SELECT * FROM threads WHERE title = ?');
            $stmt->execute(array($this->title));
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
            $stmt->execute(array($this->category_id));
            $result = $stmt->fetchAll();

            if (count($result) === 0) {
                echo '<p class="empty">No threads to show!</p>';
            } else {

                // display threads
                echo '<table class="table table-borderless">
                    <tr class="title-row">
                        <td class="title" colspan="2">Threads</td>
                    </tr>';

                foreach ($result as $res) {
                    echo '<tr class="table-row">
                            <td><a href="/forum-pdo/pages/threads.php?id=' . $res['id'] . '&page=1">' . htmlspecialchars($res['title']) . '</a></td>';

                            // get last post
                            $stmt2 = $this->db->prepare('SELECT * FROM posts WHERE thread_id = ? ORDER BY created_at DESC LIMIT 1');
                            $stmt2->execute(array($res['id']));
                            $result2 = $stmt2->fetch();

                            if (!$result2) {
                                echo '<td>No posts</td>';
                            } else {
                                echo '<td>Last post by <span><strong>' . $result2['author'] . '</strong></span>, <span><strong>' . $result2['created_at'] . '</strong></span></td>';
                            }

                    echo '</tr>';

                        
                        // if the user is an admin or a moderator, display thread buttons
                        if (isset($_SESSION['username'])) {
                          if ($_SESSION['groups'] === 'Administrator' || $_SESSION['groups'] === 'Moderator') {
                            echo '<tr class="button-row">
                                        <td>
                                            <a href="/forum-pdo/pages/edit-thread.php?id=' . $res['id'] . '&category_id=' . $this->category_id . '" class="btn btn-primary button"><span class="bi bi-pencil"></span>Edit</a>
                                            <a href="/forum-pdo/pages/delete-thread-confirm.php?id=' . $res['id'] . '&category_id=' . $this->category_id . '" class="btn btn-primary button"><span class="bi bi-trash"></span>Delete</a>
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


    public function getTitle() {
    
        try {
            $stmt = $this->db->prepare('SELECT title FROM threads WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            return '<a href="/forum-pdo/pages/threads.php?id=' . $_GET['id'] .  '&page=1">' . $result['title'] . '</a>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

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

    }


    public function threadCheck() {

        try {
            $stmt = $this->db->prepare('SELECT * FROM threads WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            if (!$result) {
                header('Location: /forum-pdo/index.php');
                exit();

            }

            if ($_SESSION['groups'] !== 'Administrator' || $_SESSION['groups'] !== 'Moderator') {
                $_SESSION['title'] = $result['title'];
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } 


    public function update() {
        try {
            $stmt = $this->db->prepare('UPDATE threads SET title = ? WHERE id = ?');
            $stmt->execute(array($this->title, $_GET['id']));      
        } catch(PDOException $e) {
            echo $e->getMessage();
            
        }
    }


    public function delete() {
        try {
            $stmt = $this->db->prepare('DELETE threads, posts 
                                        FROM threads LEFT JOIN posts ON threads.id = posts.thread_id 
                                        WHERE threads.id = ?');
            $stmt->execute(array($_GET['id']));
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>