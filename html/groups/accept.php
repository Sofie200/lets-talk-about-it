<?php
    require __DIR__ . '/../functions.php';

    if($_SERVER['REQUEST_METHOD'] === "GET") {
        header("Location: /groups");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?>Accept join request</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "POST") {

            $request_id = $db->escape_string($_GET['id']);
            $user_id = $_SESSION['user_id'];

            $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
                WHERE group_id IN (SELECT group_id FROM User_Group_Roles WHERE id = $request_id)
                AND user_id = $user_id AND is_pending = 0 AND role_id = 1");
            $rowsUserInfo = $resultUserRole->fetch_all();

                // IF admin
                if($resultUserRole->num_rows > 0){

                    $sql = "UPDATE User_Group_Roles
                        SET is_pending = 0,
                        member_since = NOW(),
                        admin_user_id = $user_id
                        WHERE id = $request_id;";
                    $result = $db->query($sql);

                }

            ?>
                <h1>Request accepted!</h1>
            <?php
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>