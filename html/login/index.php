<?php
    require __DIR__ . '/../functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $db->escape_string($_POST['username']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM Users WHERE username = '$username' LIMIT 1";
        $result = $db->query($sql);

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user['pw_hash'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // API-mode: return JSON instead of redirect
                if (isset($_GET['api'])) {
                    echo json_encode([
                        "success" => true,
                        "user_id" => $user['id'],
                        "username" => $user['username'],
                        "session_id" => session_id()
                    ]);
                    exit;
                }

                // Normal browser login
                header("Location: /");
                exit;
} else {
                echo "Wrong password";
            }

        } else {
            echo "User doesn't exist";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?>Login</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>    

    <?php

      if ($_SERVER['REQUEST_METHOD'] === 'GET'){  

        if (isset($_SESSION['username'])){

            echo "<h1>Log in</h1>";

            echo "Logged in as " . $_SESSION['username'] . ".";
            echo "<br><a href='../logout.php'>Log out</a>";    

        } else {
            
            ?>

            <h1>Log in</h1>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Log in" />
            </form>

            Not registered? <a href="/join">Sign up</a>.

        <?php
        
        }
      }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>