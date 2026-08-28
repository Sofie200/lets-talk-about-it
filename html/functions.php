<?php
    session_start();

    $db = new mysqli("db", "MyUser", "MyPassword", "lets-talk-about-it");

    if($db->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
?>