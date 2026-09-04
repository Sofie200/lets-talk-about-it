<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Login</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>    

    <?php

        echo "<h1>Log in</h1>";

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

                    echo "Logged in as " . $_SESSION['username'] . ".";
                    echo "<br><a href='../logout.php'>Log out</a>";
                    
                } else {
                    echo "Wrong password";
                }

            } else {
                echo "User doesn't exist";
            }
        } else if (isset($_SESSION['username'])){

            echo "Logged in as " . $_SESSION['username'] . ".";
            echo "<br><a href='../logout.php'>Log out</a>";    

        } else {
            
            ?>

            <form method="POST">
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Log in" />
            </form>

            Not registered? <a href="/join">Sign up</a>.

        <?php
        
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>