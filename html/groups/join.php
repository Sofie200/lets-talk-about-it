<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join group</title>
</head>
<body>

<?php

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $group_id = $db->escape_string($_GET['id']);
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO User_Group_Roles (user_id, group_id, role_id, is_user_join_request, is_pending) VALUES ('$user_id', '$group_id', '2', '1', '1')";
        $result = $db->query($sql);

        var_dump($result);
        var_dump($db->insert_id);

        ?>
            <h2>Request sent</h2>
        <?php
    }
    else {
        ?>
            <h2>Request to join</h2>

            <form method="POST" action="">
                <input type="submit" value="Send request" />
            </form>

        <?php
    }
?>
    
</body>
</html>