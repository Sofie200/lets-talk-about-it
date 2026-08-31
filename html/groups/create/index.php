<?php
    require __DIR__ . '/../../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create group</title>
</head>
<body>

<?php

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $group_name = $db->escape_string($_POST['group_name']);
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO Groups (group_name, created_by) VALUES ('$group_name', '$user_id')";
        $result = $db->query($sql);

        if ($result) {

            $new_group_id = $db->insert_id;
            
            $sql = "INSERT INTO User_Group_Roles (user_id, group_id, role_id, is_pending) VALUES ('$user_id', '$new_group_id', '1', '0')";
            $result = $db->query($sql);

            //var_dump($result);
            //var_dump($db->insert_id);

        } else {
            echo "Something went wrong";
        }

        //var_dump($result);
        //var_dump($db->insert_id);

        ?>
            <h2>Group created</h2>
        <?php
    }
    else {
        ?>
            <h2>Create group</h2>

            <form method="POST">
                <label>
                    Group name:
                    <input name="group_name" required />
                </label>

                <input type="submit" value="Create" />
            </form>

        <?php
    }
?>
    
</body>
</html>