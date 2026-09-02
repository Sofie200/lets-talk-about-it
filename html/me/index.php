<?php
    require __DIR__ . '/../functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Me</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

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

    <?php require __DIR__ . '/../layout/footer.php'; ?>

</body>

</html>