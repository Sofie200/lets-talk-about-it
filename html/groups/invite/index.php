<?php
require __DIR__ . '/../../functions.php';

$admin_id = $db->escape_string($_SESSION['user_id']);

if (!isset($admin_id)) {

        $resultUserRole = $db->query("SELECT * FROM User_Group_Roles WHERE group_id IN 
            (SELECT group_id FROM User_Group_Roles WHERE user_id = $admin_id)
            AND is_pending = 0 AND role_id = 1");

    if ($resultUserRole->num_rows == 0) {
        header("Location: /groups/group.php?id=$group_id");
        exit;
    }

    header("Location: /login");
    exit;
}

$admin_id = $db->escape_string($_SESSION['user_id']);
$message = '';
$group_id = isset($_GET['id']) ? $db->escape_string($_GET['id']) : null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $username = $db->escape_string($_POST['username']);
    $resultUserId = $db->query("SELECT id FROM Users WHERE username = '$username'");

    if ($resultUserId->num_rows == 0) {
        $message = "Cannot find user.";
    } else {

        $user_id = $resultUserId->fetch_all()[0][0];
        $token = substr(bin2hex(random_bytes(5)), 0, 10);

        $sql = "INSERT INTO Invites (hotlink) VALUES ('$token')";

        $result = $db->query($sql);

        $invite_id = $db->insert_id;

        $sql = "INSERT INTO User_Group_Roles (user_id, group_id, role_id, invite_id, is_user_join_request, is_pending, admin_user_id, member_since) 
        VALUES ($user_id, $group_id, 2, '$invite_id', 0, 1, $admin_id, NOW())";

        $result = $db->query($sql);

        $message = "<h1>User was invited!</h1>Hotlink for $username: <a href='/groups/invite/accept.php?id=$token'>/groups/invite/accept.php?id=$token</a>";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../../layout/title.php'; ?>Invite user</title>
    <link rel="stylesheet" href="/../../styles.css">
</head>
<body>

<?php require __DIR__ . '/../../layout/header.php'; ?>

<?php if (!empty($message)): ?>

    <?= $message ?>

<?php else: ?>

    <h1>Invite user to group</h1>

    <form method="POST">
        <label>
            <input type="text" name="username" placeholder="Enter username" required>
        </label>
        <input type="submit" value="Send invite">
    </form>

<?php endif; ?>

<?php require __DIR__ . '/../../layout/footer.php'; ?>

</body>
</html>
