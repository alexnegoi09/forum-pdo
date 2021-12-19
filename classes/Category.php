<?php

class Category {

    public function read() {
        require 'includes/database.php';

        //select categories from db
        try {
            $query = $pdo->query('SELECT * FROM categories');
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
                            <a href=/dev-php/forum-pdo/pages/categories.php?id=' . $res['id'] .  '>' . $res['name'] . 
                            '</a>
                             <p>' . $res['description'] . '</p>
                        </td>
                      </tr>';
                }
                echo '</table>';
            } else {
            exit('<p>No categories to show!</p>');
        }

        $pdo = null;
    }


    public function create() {
        require 'includes/database.php';

        try {
            $stmt = $pdo->prepare('INSERT INTO categories(name, description) VALUES (:name, :description)');
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
}

?>