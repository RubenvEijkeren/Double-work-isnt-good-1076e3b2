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
        $info = $pdo->query('SELECT * FROM series');
        ?>
        <form method="POST"><?php
        foreach ($info as $show) {
            foreach ($show as $key => $value) {
                if ($key != 'id'){
                    if ($key == 'description'){?>
                        <span style='font-weight:bold'><?php echo $key ?></span>: 
                        <textarea rows='10' cols='50' name='<?php echo $key ?>'></textarea><br><?php
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
                        <input type='text' name='<?php echo $key ?>'></input><br><?php
                    }
                }
            }
            break;
        }
        ?>
            <input type="submit" value="Add"></input>
        </form>
        <?php
//        var_dump($_POST);
        $pdo->query("INSERT INTO netland.series (title, rating, description, has_won_awards, seasons, country, language, media) VALUES('".$_POST['title']."', ".$_POST["rating"].", '".$_POST["description"]."', ".$_POST["has_won_awards"].", ".$_POST["seasons"].", '".$_POST["country"]."', '".$_POST["language"]."', '".$_POST['media']."')");
        ?>
</body>
</html>