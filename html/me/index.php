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
    <title><?php require __DIR__ . '/../layout/title.php'; ?> | Me</title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>

    <?php

        if($_SERVER['REQUEST_METHOD'] === "GET") {


            ?>

                <div class="top-grid">
                    <h1>
                        My Groups
                    </h1>
                    <div><a href='/groups/create'>&#10133; Create new group</a></div>
                </div>
                
            <?php

            $user_id = $_SESSION['user_id'];
      
            $result = $db->query("SELECT Groups.group_name, Groups.id, Groups.group_desc FROM User_Group_Roles 
                LEFT JOIN Groups on Groups.id = User_Group_Roles.group_id 
                WHERE User_Group_Roles.user_id = $user_id AND is_pending = 0;");
                        
            if($result->num_rows > 0) {
                $rows = $result->fetch_all();

                foreach ($rows as $row) {
                    if (isset($row['0']) && isset($row['1'])) {
                        echo "<a class='group-card' href='/groups/group.php?id=" . $row['1'] . "'><h2>" . $row['0'] . "</h2><p>" . $row['2'] . "</p></a><br>";
                    }
                }
            }else{
                echo "Nothing here yet :(";
            }
            

        }
    
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>

</body>

</html>