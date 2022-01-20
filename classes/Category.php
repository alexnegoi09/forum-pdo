<?php


class Category {
    private $name;
    private $description;
    private $db;


    public function __construct($name, $description, $db) {
        $this->name = $name;
        $this->description = $description;
        $this->db = $db;
    }


    public function read() {
        
        //select categories from db
        try {
            $query = $this->db->query('SELECT * FROM categories');
            $result = $query->fetchAll(PDO::FETCH_ASSOC);            
        } catch(PDOException $e) {
            echo $e->getMessage();
        }


        if (count($result) != 0) {

            //display categories
            echo '<table class="table table-borderless">
                    <tr class="title-row">
                        <td class="title" colspan="2">Categories</td>
                    </tr>';
            foreach($result as $res) { 
                echo '<tr class="table-row">
                        <td>
                            <a href="/forum-pdo/pages/categories.php?id=' . $res['id'] .  '">' . htmlspecialchars($res['name']) . 
                            '</a>
                             <p>' . htmlspecialchars($res['description']) . '</p>
                        </td>';

                        // get last post in category
                        try {
                            $stmt = $this->db->prepare('SELECT posts.id, posts.thread_id, posts.body, posts.author, posts.created_at, threads.category_id 
                                     FROM posts INNER JOIN threads ON posts.thread_id = threads.id INNER JOIN categories ON threads.category_id = categories.id 
                                     WHERE categories.id = ? ORDER BY posts.created_at DESC LIMIT 1');
                            $stmt->execute(array($res['id']));
                            $result2 = $stmt->fetch();
    
                            if (!$result2) {
                                echo '<td>No posts</td>';
                            } else {
                                echo '<td>Last post by <span><strong>' . $result2['author'] . '</strong></span>, <span><strong>' . $result2['created_at'] . '</strong></span></td>';
                            }
                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }
                        echo '</tr>';

                        // if the user is an admin, display category buttons
                        if (isset($_SESSION['username'])) {
                            if ($_SESSION['groups'] === 'Administrator') {
                                echo '<tr class="button-row">
                                        <td>
                                            <a href="/forum-pdo/pages/edit-category.php?id=' . $res['id'] . '" class="btn btn-primary button"><span class="bi bi-pencil"></span>Edit</a>
                                            <a href="/forum-pdo/pages/delete-category-confirm.php?id=' . $res['id'] . '" class="btn btn-primary button"><span class="bi bi-trash"></span>Delete</a>
                                        </td>
                                    </tr>';
                        }
                    }
                }

                echo '</table>';
            }
        }


    public function emptyFieldsCheck() {
        if (empty($_POST['category-title'])) {
            $_SESSION['errors'][] = 'Please enter a category title!';
        }

        if (empty($_POST['category-description'])) {
            $_SESSION['errors'][] = 'Please enter a category description!';
        }
    }


    public function duplicateCheck() {

        // check for duplicate threads
        try {
            $stmt = $this->db->prepare('SELECT * FROM categories WHERE name = ?');
            $stmt->execute(array($this->name));
            $result = $stmt->fetch();
            if ($result) {
                $_SESSION['errors'][] = 'There is already a category with the same name!';
            }
            

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function create() {

        try {
            $stmt = $this->db->prepare('INSERT INTO categories(name, description) VALUES (:name, :description)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            $name = $this->name;
            $description = $this->description;

            $stmt->execute();

            echo '<p class="text-success success">Category created! Click <a href="/forum-pdo/index.php" class="text-dark">here</a> to go to the homepage.</p>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getTitle() {
    
        try {
            $stmt = $this->db->prepare('SELECT name FROM categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            return '<a href="/forum-pdo/pages/categories.php?id=' . $_GET['id'] .  '">' . $result['name'] . '</a>';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function getPageTitle() {

        try {
            $stmt = $this->db->prepare('SELECT name FROM categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            echo $result['name'] . ' - My Forum';

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function categoryCheck() {

        try {
            $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();

            if (!$result) {
                header('Location: /forum-pdo/index.php');
                exit();

            }

            if ($_SESSION['groups'] !== 'Administrator' || $_SESSION['groups'] !== 'Moderator') {
                $_SESSION['name'] = $result['name'];
                $_SESSION['description'] = $result['description'];
            } 
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function update() {
        try {
            $stmt = $this->db->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
            $stmt->execute(array($this->name, $this->description, $_GET['id']));      
        } catch(PDOException $e) {
            echo $e->getMessage();
            
        }
    }


    public function delete() {
        try {
            $stmt = $this->db->prepare('DELETE categories, threads, posts   
                                        FROM categories LEFT JOIN threads ON categories.id = threads.category_id LEFT JOIN posts ON threads.id = posts.thread_id 
                                        WHERE categories.id = ?');
            $stmt->execute(array($_GET['id'])); 
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        }
      }
    
