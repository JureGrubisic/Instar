<?php
include("../model/db.php"); 
include("../model/user.class.php");
User::updateUserPassword();
header("Location: ../changePassword.php");
?>