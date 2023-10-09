<?php
include("../model/db.php"); 
include("../model/user.class.php");
User::addUser();
header("Location: ../superadmin-login.php");
?>