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
        <a href="">Groups</a>
        <a href="group/topics">Topics</a>
    </nav>

    <br>

    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {
      
            $result = $db->query("SELECT * FROM Groups");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['1'])) {
                        echo $row['1'] . "<br>";
                    }
                }
            }
            

        }
    
    ?>

    <br>

    <a href="group">Group</a>
    
</body>
</html>