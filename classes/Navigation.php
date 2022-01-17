<?php

class Navigation {
    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function display() {
        if (strpos($_SERVER['PHP_SELF'], 'categories')) {
            try {
                $stmt = $this->db->prepare('SELECT name FROM categories WHERE id = ?');
                $stmt->execute(array($_GET['id']));
                $result = $stmt->fetch();

                echo '<nav class="main-nav">You are here: <a href="/forum-pdo/index.php">My Forum</a> > <span><strong>' . $result['name'] . '</strong></span></nav>';
            
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        } else if (strpos($_SERVER['PHP_SELF'], 'threads')) {
            try {
                $stmt = $this->db->prepare('SELECT categories.name, threads.title, threads.category_id FROM categories 
                                            INNER JOIN threads ON categories.id = threads.category_id 
                                            WHERE threads.id = ?');
                $stmt->execute(array($_GET['id']));
                $result = $stmt->fetch();
    
                echo '<nav class="main-nav">You are here: <a href="/forum-pdo/index.php">My Forum</a> > <a href="/forum-pdo/pages/categories.php?id=' . $result['category_id'] . '">' . $result['name'] . '</a> > <span><strong>' . $result['title'] . '</strong></span></nav>';
                
            } catch(PDOException $e) {
                echo $e->getMessage();
            } 
        }
    }   
}

?>