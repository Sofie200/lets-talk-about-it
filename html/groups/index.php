<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
</head>
<body>

    <?php 

        function getMygroups(){

            $myGroups = [
                "Gaming Corner",
                "Book club",
                "Harry Styles fandom"
            ];

            return $myGroups;

        }
    
    ?>

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

        $myGroups = getMygroups();

        for($i = 0; $i < count($myGroups); $i++){
            echo $myGroups[$i] . "<br>";
        }

    ?>

    <br>

    <a href="group">Group</a>
    
</body>
</html>