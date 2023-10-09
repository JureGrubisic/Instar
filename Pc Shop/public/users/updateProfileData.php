<?php
include("../model/db.php"); 
include("../model/user.class.php");
User::updateUserProfile();
header("Location: ../changeData.php");
?>