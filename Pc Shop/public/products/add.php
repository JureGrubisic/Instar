<?php
include("../model/db.php");
include("../model/product.class.php");

// Call the saveProduct method
Product::saveProduct($_POST); // Assuming you're sending the product data via POST

// Redirect to a page after adding the product
header("Location: ../admin-login.php");
?>
