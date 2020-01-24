<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        $host = '127.0.0.1';
        $db   = 'netland';
        $user = 'root';
        $pass = 'ABC';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

        $series = $pdo->query('SELECT * FROM series');
        $highestID = $pdo->query('SELECT MAX(id) from netland.series');

        if (isset($_GET['order'])){
            if ($_GET['order'] == 'rating')
                $series = $pdo->query('SELECT * FROM series ORDER BY rating DESC');
            if ($_GET['order'] == 'title')
                $series = $pdo->query('SELECT * FROM series ORDER BY title ASC');
            if ($_GET['order'] == 'media')  
                $series = $pdo->query('SELECT * FROM series ORDER BY media ASC');

        }
        ?>
        <?php 
        foreach ($highestID as $value) {
            $nextID = $value['MAX(id)']+1;
        }
        ?>
        <h1>Netland control panel</h1>
        <h2>Series</h2>
        <table>
            <tr>
                <th><a href='index.php?order=title'>Title</a></th>
                <th><a href='index.php?order=rating'>Rating</a></th>
                <th><a href='index.php?order=media'>media</a></th>
            </tr>
            <?php  
            foreach ($series as $row) {
                echo "<tr><td>" . $row['title'] . "</td>";
                echo "<td>" . $row['rating'] . "</td>";
                echo "<td>" . $row['media'] . "</td>";
                echo "<td><a href='Series.php?id=".$row['id']."'>More info</a></td>";
                echo "<td><a href='edit.php?id=".$row['id']."'>Edit</a></td></tr>";
            }
            ?>
            <tr>
                <td><a href="add.php?id=<?php echo $nextID;?>">Add new item to List</a></td>
            </tr>
        </table>
   </body>
</html>