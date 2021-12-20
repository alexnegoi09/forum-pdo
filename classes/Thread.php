<?php

class Thread {

    public static function categoryCheck() {
        require('../includes/database.php');

        // check category id
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM  categories WHERE id = ?');
            $stmt->execute(array($_GET['id']));
            $result = $stmt->fetch();
            if (count($result) === 0) {
                header('Location: /forum-pdo/index.php');
                exit();
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        echo 'id exists!';
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
                exit('<p>This thread is empty!</p>');
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
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    
}

?>