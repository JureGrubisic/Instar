<?php

class Product{
    
    public static function getProducts (){
        global $conn;
        $upit = "SELECT * FROM products";
        $rezultat = mysqli_query($conn, $upit);
        $lista = array();
        while ($redak = mysqli_fetch_assoc($rezultat))
            array_push($lista, $redak);
        return $lista;
    }
    
    public static function deleteProduct ($id) {
        global $conn;
        $id=intval($id);
        $sql="DELETE FROM products WHERE ID=".$id;
        return mysqli_query($conn, $sql);
    }
    public static function saveProduct($korisnik){
        global $conn;
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $brand=$_POST['brand'];
            $model=$_POST['model'];
            $price=$_POST['price'];
            $screen=$_POST['screen'];
            $ram=$_POST['ram'];
            $hard_disc=$_POST['hard_disc'];
            $processor=$_POST['processor'];
            $model_processor=$_POST['model_processor'];
            $graphic_card=$_POST['graphic_card'];
            $model_graphic_card=$_POST['model_graphic_card'];
            $os=$_POST['os'];
            $weight=$_POST['weight'];
            $guarantee=$_POST['guarantee'];
            $target='../assets/laptops/'.basename($_FILES['image']['name']);
            $image=$_FILES['image']['name'];
            if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                $sql="INSERT INTO products VALUES (null,'".$brand."','".$model."','".$price."','".$screen."','".$ram."','".$processor."','".$model_processor."','".$hard_disc."','".$graphic_card."','".$model_graphic_card."','".$os."','".$weight."','".$guarantee."','assets/laptops/".$image."')";
                mysqli_query($conn,$sql);
            }
        }
    }
}
?>