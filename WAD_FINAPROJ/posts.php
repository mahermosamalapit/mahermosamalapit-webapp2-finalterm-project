<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <title>Posts Page</title>
    <style>
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url('low-poly-grid-haikei.svg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        .posts-container {
            width: 80%;
            max-width: 500px;
            height: auto;
            background-color: rgba(255, 255, 255, 0.13);
            position: relative;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 30px 20px;
            text-align: center;
        }
        .posts-container h1 {
            font-size: 28px;
            font-weight: 500;
            line-height: 36px;
            color: white;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: white;
            cursor: pointer;
            font-size: 15px;
            color: black;
        }
        li:hover {
            background-color: #0c555a;
            color: white;
        }
        li a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        li a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php
            require 'config.php';

            if (!isset($_SESSION['id'])) {
                header("Location: post.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
</html>
