<?php
require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];



$error_message = '';

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute(['username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('password123' === $password) { 
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: posts.php');
                    exit;
                } else {
                    $error_message = "Invalid Password!";
                }
            } else {
                $error_message = "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-image: url(low-poly-grid-haikei.svg);
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }
        .login-container {
            height: 350px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
            text-align: center;
        }
        .login-container h2 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            color: #39E09B;
            margin-bottom: 10px;
        }
        .login-container p {
            margin-bottom: 30px;
            color: #FFFFFF;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 15px;
            margin: 10px 0;
            border: 2px solid #FFFFFF;
            border-radius: 30px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            color: #FFFFFF;
            text-align: center;
            outline: none;
        }
        .login-container input::placeholder {
            color: #e5e5e5;
        }
        .login-container button {
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            background-color: #39E09B;
            color: black;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            margin-top: 20px;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
        }
        .login-container button:hover {
            background-color: #2EBD89;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #FFFFFF;
        }
    </style>
</head> 
<body>
    <div class="background"></div>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" id="username" placeholder="Enter username" name="username" required>
            <input type="password" id="password" placeholder="Enter password" name="password" required>
            <button id="submit">Login</button>
        </form>
    </div>
</body>
</html>
