<?php
    $conn=$hostname = 'localhost'; // Replace with the actual hostname or IP address of your MySQL server.
    $username = 'root';
    $password = ''; // Replace with the actual password for the 'root' user.
    $database = 'laptopshop'; // Replace with the name of your database.
    $port = 3306; // Replace with the actual port number if it's different.
    
    $conn = mysqli_connect($hostname, $username, $password, $database, $port);
    
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    
    ;
    //$conn=mysqli_connect('localhost','root','','ls_shop');

    //if(!$conn){
    //    die ("Conection failed!" . mysqli_connect_error());
    //}
?>