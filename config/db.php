<?php
    $server_name = "localhost"; 
    $username = "root"; 
    $password = "2024"; 
    $database_name = "zera";

    $conn = new mysqli($server_name, $username, $password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
    }
?>  


