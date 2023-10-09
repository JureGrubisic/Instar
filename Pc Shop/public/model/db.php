<?php
    $conn=$hostname = 'localhost'; 
    $username = 'root';
    $password = '';
    $database = 'pcshop'; 
    $port = 3306;
    
    $conn = mysqli_connect($hostname, $username, $password, $database, $port);
    //$conn=mysqli_connect('localhost','fpmoz132023','csdigital2023','fpmoz132023')
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    
    ;
    
?>
