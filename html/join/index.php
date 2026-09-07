<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?>Join</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>
    
    <?php require __DIR__ . '/../layout/header.php'; ?>

    <h1>Sign up</h1>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "POST") {

            $username = $db->escape_string($_POST['username']);
            $first_name = $db->escape_string($_POST['first_name']);
            $last_name = $db->escape_string($_POST['last_name']);
            $email = $db->escape_string($_POST['email']);
            $password = $db->escape_string($_POST['password']);
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO Users (username, first_name, last_name, email, pw_hash) VALUES ('$username', '$first_name', '$last_name', '$email', '$pw_hash')";
            $result = $db->query($sql);

            ?>
                <h3>Account created. <a href="/login">Log in</a>.</h3>
            <?php
        }
        else {
            ?>

                <form method="POST">
                    <label>
                        Username:
                        <input type="text" name="username" required />
                    </label>

                    <label>
                        First name:
                        <input type="text" name="first_name" required />
                    </label>

                    <label>
                        Last name:
                        <input type="text" name="last_name" required />
                    </label>

                    <label>
                        Email:
                        <input type="email" name="email" required />
                    </label>

                    <label>
                        Password:
                        <input type="password" name="password" required />
                    </label>

                    <input type="submit" value="Join" />
                </form>

            <?php
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>