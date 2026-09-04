<?php
    require __DIR__ . '/../../functions.php';

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $topic_name = $db->escape_string($_POST['topic_name']);
        $topic_desc = $db->escape_string($_POST['topic_desc']);
        $group_id = $db->escape_string($_GET['id']);
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO Topics (topic_name, description, user_id, group_id) VALUES ('$topic_name', '$topic_desc', '$user_id', '$group_id')";
        $result = $db->query($sql);

        if ($result) {

            $topic_id = $db->insert_id;
            header("Location: /groups/group.php?id=$group_id");
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
    <title><?php require __DIR__ . '/../../layout/title.php'; ?> | Create topic</title>
    <link rel="stylesheet" href="/../../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../../layout/header.php'; ?>

    <?php

        $group_id = $db->escape_string($_GET['id']);
        $user_id = $_SESSION['user_id'];

        $resultUserRole = $db->query("SELECT * FROM User_Group_Roles WHERE group_id = $group_id AND user_id = $user_id AND is_pending = 0");
        $rowsUserInfo = $resultUserRole->fetch_all();

        // IF not a member
        if($resultUserRole->num_rows == 0){

            echo "Not authorized";
            die;

        }else{

            if($_SERVER['REQUEST_METHOD'] === "GET") {
            ?>
                <h1>Create topic</h1>

                <form method="POST">
                    <label>
                        Topic name:
                        <input type="text" name="topic_name" required />
                    </label>

                    <label>
                        Topic desc:
                        <textarea name="topic_desc" required></textarea>
                    </label>

                    <input type="submit" value="Create" />
                </form>

            <?php
            }
        }
    ?>

    <?php require __DIR__ . '/../../layout/footer.php'; ?>
        
</body>
</html>