<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Groups</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

    <h1>
        Groups
    </h1>

    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {

            echo "<p><a href='/groups/create'>Create new group</a></p>";
      
            $result = $db->query("SELECT * FROM Groups");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['0']) && isset($row['1'])) {
                        echo "<a href='group.php?id=" . $row['0'] . "'>" . $row['1'] . "</a><br>";
                    }
                }
            }
            

        }
    
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>