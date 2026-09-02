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

                    echo "Du är inloggad som " . $_SESSION['username'];
                    echo "<a href='../logout.php'>Logga ut</a>";
                    
                } else {
                    echo "Fel lösenord.";
                }

            } else {
                echo "Användaren finns inte.";
            }
        }
    ?>

    <form method="POST">
        <input name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Logga in" />
    </form>

    Inte registrerad? <a href="/join">Skapa användare</a>

    <?php
        if (!isset($_SESSION['username'])) {
            echo "Sessionen är död";
        } else {
        echo "Sessionen lever: " . $_SESSION['username'];
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>