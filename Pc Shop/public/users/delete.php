<?php
include("../model/db.php"); 
include("../model/user.class.php");
User::deleteUser($_GET["id"]);
header("Location: ../superadmin-login.php");
?>