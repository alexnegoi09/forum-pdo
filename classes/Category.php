<?php


class Category {
    public $db;


    public function __construct($db) {
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
            echo '<table>
                    <tr>
                        <td>Categories</td>
                    </tr>';
            foreach($result as $res) {
                echo '<tr>
                        <td>
                            <a href=/forum-pdo/pages/categories.php?id=' . $res['id'] .  '>' . $res['name'] . 
                            '</a>
                             <p>' . $res['description'] . '</p>
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
                                echo '<td>Last post by <span>' . $result2['author'] . '</span> on <span>' . $result2['created_at'] . '</span></td>';
                            }
                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }
                    }

                echo '</tr>';


                echo '</table>';
            } else {
            exit('<p>No categories to show!</p>');
        }

    }


    public function create() {

        try {
            $stmt = $this->db->prepare('INSERT INTO categories(name, description) VALUES (:name, :description)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            $name = $_POST['name'];
            $description = $_POST['description'];

            $stmt->execute();

            echo '<p>Category created! Click <a href=/dev-php/forum-pdo/index.php>here</a> to go to the homepage.</p>';

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
}

?>