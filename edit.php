<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
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
        $info = $pdo->query('SELECT * FROM series WHERE id = ' . $_GET['id']);
        ?>
        <form method="post"><?php
        foreach ($info as $show) {
            foreach ($show as $key => $value) {
                if ($key != 'id'){
                    if ($key == 'description'){?>
                        <span style='font-weight:bold'><?php echo $key; ?></span>: 
                        <textarea rows='10' cols='50' name='<?php echo $key ?>'><?php echo $value; ?></textarea><br><?php
                    }
                    elseif ($key == 'media') {?>
                        <span style='font-weight:bold'><?php echo $key ?></span>
                        <select name='<?php echo $key ?>'>
                            <option value='movie'>movie</option>
                            <option value='serie'>serie</option>
                        </select>
                        <?php
                    }
                    else{?>
                        <span style='font-weight:bold'><?php echo $key; ?></span>: 
                        <input type='text' value='<?php echo $value ?>' name='<?php echo $key ?>'></input><br><?php
                    }
                }
            }
        }
        ?>
        <input type="submit" value="Edit"></input>
    </form>
    <?php  
//        var_dump($_POST);
        foreach ($_POST as $key => $value) {
//            echo "UPDATE series SET ".$key." = '".$value."' WHERE id = ".$_GET['id']."<br>";
            if ($value != 'Edit'){
                if (!is_numeric($value)){
                    $pdo->query("UPDATE series SET ".$key." = '".$value."' WHERE id = ".$_GET['id']);
                }
                else{
                    $pdo->query("UPDATE series SET ".$key." = ".$value." WHERE id = ".$_GET['id']);
                }
            }
        }
    ?>
</body>
</html>