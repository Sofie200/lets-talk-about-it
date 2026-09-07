<?php
    require __DIR__ . '/../../functions.php';

    $group_id = $db->escape_string($_GET['id']);

     if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }else{
        $user_id = $db->escape_string($_SESSION['user_id']);

        $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
            WHERE group_id = $group_id
            AND user_id = $user_id AND is_pending = 0 AND role_id = 1");
        $rowsUserInfo = $resultUserRole->fetch_all();

        if($resultUserRole->num_rows == 0){
            header("Location: /login");
            exit;
        }

    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $ugp_id = $db->escape_string($_POST['ugp_id']);
        $role_id = $db->escape_string($_POST['role_id']);

        $sql = "UPDATE User_Group_Roles
                SET role_id = $role_id
                WHERE id = $ugp_id";

        $db->query($sql);

        header("Location: /groups/manage?id=" . $group_id);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../../layout/title.php'; ?>Groups</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../../layout/header.php'; ?>
    <?php 
    
        if($_SERVER['REQUEST_METHOD'] === "GET") { ?>

            <div class="top-grid">
                <h1>
                    Manage user roles
                </h1>
                <div><a href='/groups/group.php?id=<?=$group_id?>'>&#11013; Back</a></div>
            </div>

    <?php

            $sql = "SELECT u.username, ugp.role_id, ugp.id
                FROM User_Group_Roles ugp
                INNER JOIN Users u ON u.id = ugp.user_id
                WHERE ugp.group_id = $group_id
                AND ugp.is_pending = 0";

            $result = $db->query($sql);
            $members = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($members as $m): ?>
                <div class="member-row">

                    <?php if ($m['role_id'] == 1): ?>
                        <!-- Admin → visa Make member -->
                         <span><?= htmlspecialchars($m['username']) ?> | <b><i>Admin</i></b></span>
                        <form method="POST">
                            <input type="hidden" name="ugp_id" value="<?= $m['id'] ?>">
                            <input type="hidden" name="role_id" value="2">
                            <input type="submit" value="Make member">
                        </form>
                    <?php else: ?>
                        <!-- Member → visa Make admin -->
                         <span><?= htmlspecialchars($m['username']) ?> | <b><i>Member</i></b></span>
                        <form method="POST">
                            <input type="hidden" name="ugp_id" value="<?= $m['id'] ?>">
                            <input type="hidden" name="role_id" value="1">
                            <input type="submit" value="Make admin">
                        </form>
                    <?php endif; ?>
                </div>
                    
            <?php 
            endforeach; 
        }

    require __DIR__ . '/../../layout/footer.php'; ?>
    
</body>
</html>