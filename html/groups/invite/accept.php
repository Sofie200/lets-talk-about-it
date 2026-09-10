<?php
require __DIR__ . '/../../functions.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }

    $token = $db->escape_string($_GET['id']);
    $user_id = (int) $_SESSION['user_id'];

    $resultUserRole = $db->query("
        SELECT ugp.id, ugp.group_id
        FROM User_Group_Roles ugp
        LEFT JOIN Invites i ON i.id = ugp.invite_id
        WHERE i.hotlink = '$token'
        AND ugp.user_id = $user_id
        AND i.is_used = 0
        AND i.expires_at >= NOW();");

    // IF NOT correct user OR if token is already used OR if token expired.
    if ($resultUserRole->num_rows == 0) {
        header("Location: /login");
        exit;
    }

    $rowsUserRole = $resultUserRole->fetch_all();
    $ugp_id = $rowsUserRole[0][0];
    $group_id = $rowsUserRole[0][1];

    // 1. Uppdatera User_Group_Roles
    $db->query("UPDATE User_Group_Roles
                SET is_pending = 0, member_since = NOW()
                WHERE id = $ugp_id");

    // 2. Uppdatera Invites via invite_id-kopplingen
    $db->query("UPDATE Invites
                SET is_used = 1
                WHERE id = (SELECT invite_id FROM User_Group_Roles WHERE id = $ugp_id)");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../../layout/title.php'; ?>Create group</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

    <?php require __DIR__ . '/../../layout/header.php'; ?>

    <h1>Invite accepted</h1>
    <a href="/groups/group.php?id=<?=$group_id?>">Explore group!</a>

    <?php require __DIR__ . '/../../layout/footer.php'; ?>
</body>
</html>