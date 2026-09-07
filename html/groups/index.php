<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?>Groups</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>
    <?php if($_SERVER['REQUEST_METHOD'] === "GET") { ?>

            <div class="top-grid">
                <h1>
                    Groups
                </h1>
                <div><a href='/groups/create'>&#10133; Create new group</a></div>
            </div>

        <?php 
      
            $result = $db->query("SELECT g.id, g.group_name, g.group_desc, g.created_at, u.username FROM Groups g
                LEFT JOIN Users u ON u.id = g.created_by
                ORDER BY g.created_at DESC;");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['0'])) {
                        echo "<a class='group-card' href='group.php?id=" . $row['0'] . "'><h2>" . $row['1'] . "</h2><p>" . $row['2'] . "</p><div>" . $row['4'] . " " . $row['3'] . "</div></a><br>";
                    }
                }
            }
            

        }
    
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>