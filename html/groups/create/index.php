<?php
    require __DIR__ . '/../../functions.php';

    if ($_SERVER['REQUEST_METHOD'] === "GET") { 
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $group_name = $db->escape_string($_POST['group_name']);
        $group_desc = $db->escape_string($_POST['group_desc']);
        $user_id = $db->escape_string($_SESSION['user_id']);

        $sql = "INSERT INTO Groups (group_name, group_desc, created_by) VALUES ('$group_name', '$group_desc', '$user_id')";
        $result = $db->query($sql);

        if ($result) {

            $new_group_id = $db->insert_id;
            
            $sql = "INSERT INTO User_Group_Roles (user_id, group_id, role_id, is_pending) VALUES ('$user_id', '$new_group_id', '1', '0')";
            $result = $db->query($sql);
            
            header("Location: /groups/group.php?id=$new_group_id");

            exit;

        } else {
            echo "Something went wrong";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../../layout/title.php'; ?>Create group</title>
    <link rel="stylesheet" href="/../../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../../layout/header.php'; ?>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "GET") {
            ?>
                <h1>Create group</h1>

                <form method="POST">
                    <label>
                        Group name:
                        <input type="text" name="group_name" required />
                    </label>

                    <label>
                        Group description:
                        <textarea name="group_desc" required /></textarea>
                    </label>

                    <input type="submit" value="Create" />
                </form>

            <?php
        }
    ?>

    <?php require __DIR__ . '/../../layout/footer.php'; ?>
    
</body>
</html>