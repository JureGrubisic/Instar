<?php
    $conn=$hostname = 'localhost'; 
    $username = 'pzi132023';
    $password = 'csdigital2023';
    $database = 'pzi132023'; 
    $port = 3306;
    
    $conn = mysqli_connect($hostname, $username, $password, $database, $port);
    $conn=mysqli_connect('localhost','pzi132023','csdigital2023','pzi132023')
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    
    ;
    
?>
