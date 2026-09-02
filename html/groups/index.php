<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
</head>
<body>

    <h1>
        Groups
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
    
</body>
</html>