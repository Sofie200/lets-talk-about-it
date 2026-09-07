<?php
    require __DIR__ . '/../../functions.php';

    if ($_SERVER['REQUEST_METHOD'] === "GET") { 
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $invite_id = $db->escape_string($_GET['id']);
        $user_id = $_SESSION['user_id'];

        $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
            WHERE group_id IN (SELECT group_id FROM User_Group_Roles WHERE invite_id = $invite_id)
            AND user_id = $user_id AND is_pending = 0 AND role_id = 1");
        $rowsUserInfo = $resultUserRole->fetch_all();

        // IF NOT admin
        if($resultUserRole->num_rows = 0){

            header("Location: /login");
            exit;
        
        }else{

            $sql = "UPDATE User_Group_Roles
                SET is_pending = 0,
                member_since = NOW(),
                admin_user_id = $user_id
                WHERE id = $invite_id;";
            $result = $db->query($sql);

        }

        ?>
            <h1>Invite accepted!</h1>
        <?php
        }

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