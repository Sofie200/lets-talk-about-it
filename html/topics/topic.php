<?php
    require __DIR__ . '/../functions.php';
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
    </nav>

    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {

            $topic_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];

            $resultTopicInfo = $db->query("SELECT t.topic_name, t.description, t.created_at, u.username, g.group_name FROM Topics t
                LEFT JOIN Users u ON u.id = t.user_id
                LEFT JOIN Groups g ON g.id = t.group_id
                WHERE t.id = $topic_id
                ORDER BY t.created_at DESC;");
                        
            if($resultTopicInfo->num_rows > 0) {
                $rows = $resultTopicInfo->fetch_all();
                echo "<h1>" . $rows['0']['0'] . "</h1><p>" . $rows['0']['1'] . "</p><i>" . $rows['0']['3'] . " " . $rows['0']['2'] . " i gruppen " . $rows['0']['4'] . "</i><br><br>";
            }

            $resultUserRole = $db->query("SELECT * FROM User_Group_Roles 
                WHERE group_id IN (SELECT group_id FROM Topics WHERE id = $topic_id)
                AND user_id = $user_id 
                AND is_pending = 0");

            $rowsUserInfo = $resultUserRole->fetch_all();

            // IF not a member
            if($resultUserRole->num_rows == 0){

                echo "<h2>Not authorized</h2>";

                die;
            }

            // IF Member
            else if($resultUserRole->num_rows > 0){
                
                $resultPosts = $db->query("SELECT p.description, p.created_at, u.username FROM Posts p
                    LEFT JOIN Users u ON u.id = p.user_id
                    WHERE p.topic_id = $topic_id
                    ORDER BY p.created_at DESC;");

                $rowsPosts = $resultPosts->fetch_all();
                            
                if($resultPosts->num_rows > 0) {

                    foreach ($rowsPosts as $row) {
                        echo "<p>" . $row['0'] . "<br>" . $row['2'] . " " . $row['1'] . "</p>";
                    }
                                    
                }
                
            }
        }
    ?>

    
</body>
</html>