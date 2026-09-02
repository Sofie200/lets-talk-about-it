<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topics</title>
</head>
<body>

    <h1>
        Topics
    </h1>

    <nav>
        <a href="/">Home</a>
        <a href="/groups">Groups</a>
        <a href="/topics">Topics</a>
        <a href="/me">Me</a>
        <a href="/login">Log in</a>
    </nav>

    <br>

    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {
      
            $result = $db->query("SELECT t.id, t.topic_name, t.description, u.username, g.group_name FROM Topics t
                LEFT JOIN Users u ON u.id = t.user_id
                LEFT JOIN Groups g ON g.id = t.group_id
                ORDER BY t.created_at DESC;");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['0']) && isset($row['1'])) {
                        echo "<a href='topic.php?id=" . $row['0'] . "'>" . $row['1'] . "</a><br>" . $row['2'] . "<br>by: " . $row['3'] . " in: " . $row['4'] . "<br><br>";
                    }
                }
            }
            

        }
    
    ?>
    
</body>
</html>