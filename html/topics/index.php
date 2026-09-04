<?php
    require __DIR__ . '/../functions.php';

    if ($_SERVER['REQUEST_METHOD'] === "GET") { 
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }
    }
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

    <div class="top-grid">
        <h1>Topics</h1>
        <div></div>
    </div>

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
                        echo "<a class='group-card' href='topic.php?id=" . $row['0'] . "'><h2>" . $row['1'] . "</h2><p>" . $row['2'] . "</p><div>" . $row['3'] . " in " . $row['4'] . "</div></a><br>";
                    }
                }
            }
            

        }
    
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>