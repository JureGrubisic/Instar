<?php
include("../model/db.php"); 
include("../model/product.class.php");
Product::deleteProduct($_GET["id"]);
header("Location: ../admin-login.php");
?>