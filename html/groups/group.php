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
        
    
        <?php 

            if($_SERVER['REQUEST_METHOD'] === "GET") {
        
                $id = $_GET['id'];
                $user_id = $_SESSION['user_id'];

                $result = $db->query("SELECT * FROM User_Group_Roles WHERE group_id = $id AND user_id = $user_id AND is_pending = 0");

                if($result->num_rows == 0){
                    echo "Not allowed to view this page";
                    die;
                }


                $result = $db->query("SELECT * FROM Groups WHERE id = $id");
                            
                if($result->num_rows > 0) {
                                    
                    if($result->num_rows > 0) {
                        $rows = $result->fetch_all();
                        echo $rows['0']['1'];
                    }
                }
            }
        
        ?>

    </h1>

    <nav>
        <a href="/">Home</a>
        <a href="">Groups</a>
        <a href="group/topics">Topics</a>
    </nav>
    
</body>
</html>