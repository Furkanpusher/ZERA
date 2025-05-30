<?php
    $server_name = "localhost"; 
    $username = "u196750899_ZERA"; 
    $password = "Furkanpro14789qaz."; 
    $database_name = "u196750899_ZERA";

    $conn = new mysqli($server_name, $username, $password, $database_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else{
    }
?>  


