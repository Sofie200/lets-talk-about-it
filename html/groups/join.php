<?php
    require __DIR__ . '/../functions.php';

    if($_SERVER['REQUEST_METHOD'] === "GET") {
        header("Location: /groups/group.php?id=" . $_GET['id']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Join group</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "POST") {

            $group_id = $db->escape_string($_GET['id']);
            $user_id = $_SESSION['user_id'];

            $sql = "INSERT INTO User_Group_Roles (user_id, group_id, role_id, is_user_join_request, is_pending) VALUES ('$user_id', '$group_id', '2', '1', '1')";
            $result = $db->query($sql);

            ?>
                <h1>Join request sent!</h2>
            <?php
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>