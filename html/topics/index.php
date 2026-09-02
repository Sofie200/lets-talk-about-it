<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Topics</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

    <h1>Topics</h1>

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

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>