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
    
    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {

            $group_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];

            $resultGroupInfo = $db->query("SELECT * FROM Groups WHERE id = $group_id");
                        
            if($resultGroupInfo->num_rows > 0) {
                                
                if($resultGroupInfo->num_rows > 0) {
                    $rows = $resultGroupInfo->fetch_all();
                    echo "<h1>" . $rows['0']['1'] . "</h1>";
                }
            }

        }
    
    ?>

    <nav>
        <a href="/">Home</a>
        <a href="">Groups</a>
        <a href="group/topics">Topics</a>
    </nav>

    <?php 

        if($_SERVER['REQUEST_METHOD'] === "GET") {

            $group_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];

            $resultUserRole = $db->query("SELECT * FROM User_Group_Roles WHERE group_id = $group_id AND user_id = $user_id AND is_pending = 0");
            $rowsUserInfo = $resultUserRole->fetch_all();

            // IF not a member
            if($resultUserRole->num_rows == 0){

            ?>

                <h2>Request to join</h2>

                <form method="POST" action="join.php?id=<?= $group_id ?>">
                    <input type="submit" value="Send request" />
                </form>

            <?php

                die;

            }

            // IF Member
            else if($resultUserRole->num_rows > 0){
                
                echo "Member";

                // IF Admin
                if($rowsUserInfo['0']['3'] == '1'){
                    
                    echo "Admin";

                    if($_SERVER['REQUEST_METHOD'] === "GET") {

                        $resultJoinRequests = 
                            $db->query("SELECT first_name, last_name, User_Group_Roles.id FROM User_Group_Roles
                            INNER JOIN Users ON Users.id = User_Group_Roles.user_id
                            WHERE is_user_join_request = 1 AND is_pending = 1 AND group_id = $group_id;");
                        $rowsJoinRequest = $resultJoinRequests->fetch_all();

                        if($resultJoinRequests->num_rows > 0){

                            echo "<h3>Join requests:</h3>";

                            foreach ($rowsJoinRequest as $row) {
                                if (isset($row['2'])) {
                                    echo $row['0'] . " " . $row['1'] . "<form method='POST' action='accept.php?id=" . $row['2'] . "'><input type='submit' value='Accept' /></form><br>";
                                }
                            }
                        }

                    }

                }
            }
        }
    ?>

    
</body>
</html>