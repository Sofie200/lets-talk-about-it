<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me</title>
</head>

<body>

    <h1>
        My Groups
    </h1>

    <nav>
        <a href="/">Home</a>
        <a href="/groups">Groups</a>
        <a href="group/topics">Topics</a>
    </nav>

    <br>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "GET") {

            $user_id = $_SESSION['user_id'];
      
            $result = $db->query("SELECT Groups.group_name, Groups.id FROM User_Group_Roles 
                LEFT JOIN Groups on Groups.id = User_Group_Roles.group_id 
                WHERE User_Group_Roles.user_id = $user_id AND is_pending = 0;");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['0']) && isset($row['1'])) {
                        echo "<a href='/groups/group.php?id=" . $row['1'] . "'>" . $row['0'] . "</a><br>";
                    }
                }
            }
            

        }
    
    ?>

</body>

</html>