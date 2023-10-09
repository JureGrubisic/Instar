<?php
include("../model/db.php"); 
include("../model/user.class.php");
User::updateUser();
header("Location: ../superadmin-login.php");
?>