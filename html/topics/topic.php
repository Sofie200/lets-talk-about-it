<?php
    require __DIR__ . '/../functions.php';

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $user_id = $_SESSION['user_id'];
        $topic_id = $db->escape_string($_GET['id']);
        $message = $db->escape_string($_POST['message']);

        $sql = "INSERT INTO Posts (user_id, topic_id, description) VALUES ('$user_id', '$topic_id', '$message')";
        $result = $db->query($sql);

        header("Location: topic.php?id=" . $topic_id);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topic</title>
</head>
<body>        
    

    <nav>
        <a href="/">Home</a>
        <a href="/groups">Groups</a>
        <a href="/topics">Topics</a>
        <a href="/me">Me</a>
        <a href="/login">Log in</a>
    </nav>
    
    <?php 

    if($_SERVER['REQUEST_METHOD'] === "GET") {

            $topic_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];
            $group_id = null;

            $resultTopicInfo = $db->query("SELECT t.topic_name, t.description, t.created_at, u.username, g.group_name, g.id FROM Topics t
                LEFT JOIN Users u ON u.id = t.user_id
                LEFT JOIN Groups g ON g.id = t.group_id
                WHERE t.id = $topic_id
                ORDER BY t.created_at DESC;");
                        
            if($resultTopicInfo->num_rows > 0) {
                $rows = $resultTopicInfo->fetch_all();

                global $group_id;
                $group_id = $rows['0']['5'];

                echo "<h1>" . $rows['0']['0'] . "</h1><p>" . $rows['0']['1'] . "</p><i>" . $rows['0']['3'] . " " . $rows['0']['2'] . " i gruppen " . $rows['0']['4'] . "</i><br><br>";
            }

            $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
                WHERE group_id IN (SELECT group_id FROM Topics WHERE id = $topic_id)
                AND user_id = $user_id 
                AND is_pending = 0");

            $rowsUserInfo = $resultUserRole->fetch_all();

            // IF not a member
            if($resultUserRole->num_rows == 0){
                ?>
                <h2>Not authorized</h2>

                <h2>Request to join</h2>

                <form method="POST" action="/groups/join.php?id=<?=$group_id?>">
                    <input type="submit" value="Send request" />
                </form>

                <?php 
                die;
            }

            // IF Member
            else if($resultUserRole->num_rows > 0){
                
                $resultPosts = $db->query("SELECT p.description, p.created_at, u.username FROM Posts p
                    LEFT JOIN Users u ON u.id = p.user_id
                    WHERE p.topic_id = $topic_id
                    ORDER BY p.created_at ASC;");

                $rowsPosts = $resultPosts->fetch_all();
                            
                if($resultPosts->num_rows > 0) {

                    foreach ($rowsPosts as $row) {
                        echo "<p>" . $row['0'] . "<br>" . $row['2'] . " " . $row['1'] . "</p>";
                    }
                                    
                }

                ?>

                <h2>Join conversation</h2>

                <form method="POST" action="topic.php?id=<?=$topic_id?>">
                    <label>
                        Message:
                        <input name="message" required />
                    </label>
                    <input type="submit" value="Post" />
                </form>

                <?php
                
            }
        }
    ?>

    
</body>
</html>