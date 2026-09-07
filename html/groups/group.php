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
    <title><?php require __DIR__ . '/../layout/title.php'; ?></title>
    <link rel="stylesheet" href="/../styles.css">
</head>
<body>

    <?php require __DIR__ . '/../layout/header.php'; ?>
    
    <?php 
    
        if($_SERVER['REQUEST_METHOD'] === "GET") {  
        
            $group_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];
            $group_name = "";

            $resultGroupInfo = $db->query("SELECT g.id, g.group_name, g.group_desc, g.created_at, u.username FROM Groups g
                LEFT JOIN Users u ON u.id = g.created_by
                WHERE g.id = $group_id;");
                        
            if($resultGroupInfo->num_rows > 0) {
                                
                if($resultGroupInfo->num_rows > 0) {
                    $rows = $resultGroupInfo->fetch_all();

                    global $group_name;
                    $group_name = $rows['0']['1'];

                    ?>

                        <script type="text/javascript">
                            document.title = document.title + "<?=$group_name?>";
                        </script>
                        <div class="top-grid">
                            <div>
                                <h1><?=$rows['0']['1']?></h1>
                                <p><?=$rows['0']['2']?></p>
                                <div class="fine-print"><?=$rows['0']['4']?> <?=$rows['0']['3']?></div>
                            
                    <?php

                }
            }

            $resultUserRole = $db->query("SELECT *
                FROM User_Group_Roles ugp
                LEFT JOIN Invites i ON i.id = ugp.invite_id
                WHERE (i.expires_at IS NULL OR i.expires_at >= NOW()) AND ugp.group_id = $group_id AND ugp.user_id = $user_id
                ORDER BY ugp.member_since DESC LIMIT 1;");
            $rowsUserInfo = $resultUserRole->fetch_all();

            // IF not a member
            if($resultUserRole->num_rows == 0){

            ?>

                    </div>
                </div>
            
                <br>

                <form method="POST" action="join.php?id=<?= $group_id ?>">
                    <input type="submit" value="Request to join group" />
                </form>

            <?php

                die;
            } // IF Invited
            else if($resultUserRole->num_rows > 0 && $rowsUserInfo[0][6] == 1 && $rowsUserInfo[0][4] != null){
                
                $token = $rowsUserInfo[0][10];

                echo "<br><div class='invite-received'><h3>You've been invited to join!</h3><div><a href='/groups/invite/accept.php?id=$token' class='btn'>Accept</a><div></div>";

            // IF Join request sent
            } else if($resultUserRole->num_rows > 0 && $rowsUserInfo[0][6] == 1 && $rowsUserInfo[0][5] == 1){

                echo "<br><b>Join request is pending.</b>";

            // IF Member
            } else if($resultUserRole->num_rows > 0 && $rowsUserInfo[0][6] == 0){

                ?>
                    </div>
                    <div>
                        <a href='/groups/invite?id=<?=$group_id?>'>&#128100; Invite user</a> &nbsp; 
                        <a href='/topics/create?id=<?=$group_id?>'>&#10133; Create new topic</a>
                    </div>
                </div>

                <?php
                
                // IF Admin
                if($rowsUserInfo['0']['3'] == '1'){

                    if($_SERVER['REQUEST_METHOD'] === "GET") {

                        $resultJoinRequests = 
                            $db->query("SELECT first_name, last_name, User_Group_Roles.id FROM User_Group_Roles
                            INNER JOIN Users ON Users.id = User_Group_Roles.user_id
                            WHERE is_user_join_request = 1 AND is_pending = 1 AND group_id = $group_id;");
                        $rowsJoinRequest = $resultJoinRequests->fetch_all();

                        if($resultJoinRequests->num_rows > 0){

                            echo "<div class='join-requests'><h3>Join requests:</h3>";

                            foreach ($rowsJoinRequest as $row) {
                                if (isset($row['2'])) {
                                    echo "<div><span>";
                                    echo $row['0'] . " " . $row['1'] . "</span><form method='POST' action='accept.php?id=" . $row['2'] . "'><input type='submit' value='Accept' /></form>";
                                    echo "</div>";
                                }
                            }

                            echo "</div>";
                        }

                    }

                }

                global $group_id;

                $resultTopics = $db->query("SELECT t.topic_name, t.description, t.created_at, u.username, t.id FROM Topics t
                    LEFT JOIN Users u ON u.id = t.user_id
                    WHERE t.group_id = $group_id 
                    ORDER BY t.created_at DESC;");

                $rowsPosts = $resultTopics->fetch_all();
                            
                if($resultTopics->num_rows > 0) {

                    echo "<br><h2>Group Topics</h2>";

                    foreach ($rowsPosts as $row) {
                        echo "<a class='topic-card' href='/topics/topic.php?id=" . $row['4'] . "'><h3>" . $row['0'] . "</h3><p>" . $row['1'] . "</p><div>" . $row['2'] . " " . $row['3'] . "</div></a><br>";
                    }
                                    
                }
                
            }
        }
    ?>

    <?php require __DIR__ . '/../layout/footer.php'; ?>
    
</body>
</html>