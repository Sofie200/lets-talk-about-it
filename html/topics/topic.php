<?php
    require __DIR__ . '/../functions.php';

    $user_id = $_SESSION['user_id'];
    $topic_id = $db->escape_string($_GET['id']);


    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $message = $db->escape_string($_POST['message']);

        $sql = "INSERT INTO Posts (user_id, topic_id, description) VALUES ('$user_id', '$topic_id', '$message')";
        $result = $db->query($sql);

        header("Location: topic.php?id=" . $topic_id);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "GET") {

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $group_id = null;
        global $topic_id;

        $resultTopicInfo = $db->query("SELECT t.topic_name, t.description, t.created_at, u.username, g.group_name, g.id FROM Topics t
            LEFT JOIN Users u ON u.id = t.user_id
            LEFT JOIN Groups g ON g.id = t.group_id
            WHERE t.id = $topic_id
            ORDER BY t.created_at DESC;");
                    
        if($resultTopicInfo->num_rows > 0) {
            $rows = $resultTopicInfo->fetch_all();

            global $group_id;
            $group_id = $rows['0']['5'];

        }

        $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
            WHERE group_id IN (SELECT group_id FROM Topics WHERE id = $topic_id)
            AND user_id = $user_id 
            AND is_pending = 0");

        $rowsUserInfo = $resultUserRole->fetch_all();

        // IF not a member
        if($resultUserRole->num_rows == 0){
            header("Location: /groups/group.php?id=$group_id");
            die;
        }

        // IF Member
        else if($resultUserRole->num_rows > 0){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Topic</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; 
    
    echo "<h1>" . $rows['0']['0'] . "</h1><p>" . $rows['0']['1'] . "</p><i>" . $rows['0']['3'] . " " . $rows['0']['2'] . " in <a href='/groups/group.php?id=" . $rows['0']['5'] . "'>" . $rows['0']['4'] . "</a></i><br><br>";
    
    $resultPosts = $db->query("SELECT p.description, p.created_at, u.username FROM Posts p
        LEFT JOIN Users u ON u.id = p.user_id
        WHERE p.topic_id = $topic_id
        ORDER BY p.created_at ASC;");

    $rowsPosts = $resultPosts->fetch_all();
                
    if($resultPosts->num_rows > 0) {

        foreach ($rowsPosts as $row) {
            echo "<div class='post-card'><p>" . $row['0'] . "<br><span class='fine-print'>" . $row['2'] . " " . $row['1'] . "</span></p></div>";
        }
                        
    }

    ?>

    <br>
    <form method="POST" action="topic.php?id=<?=$topic_id?>">
        <label>
            <h2>Join conversation</h2>
            <textarea name="message" required></textarea>
        </label>
        <input type="submit" value="Post" />
    </form>


    <?php 
        }
    }
    require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>