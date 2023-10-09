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
    public static function saveProduct($data){
        global $conn;
    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $brand = mysqli_real_escape_string($conn, $data['brand']);
            $model = mysqli_real_escape_string($conn, $data['model']);
            $price = mysqli_real_escape_string($conn, $data['price']);
            $screen = mysqli_real_escape_string($conn, $data['screen']);
            $ram = mysqli_real_escape_string($conn, $data['ram']);
            $hard_disc = mysqli_real_escape_string($conn, $data['hard_disc']);
            $processor = mysqli_real_escape_string($conn, $data['processor']);
            $model_processor = mysqli_real_escape_string($conn, $data['model_processor']);
            $graphic_card = mysqli_real_escape_string($conn, $data['graphic_card']);
            $model_graphic_card = mysqli_real_escape_string($conn, $data['model_graphic_card']);
            $os = mysqli_real_escape_string($conn, $data['os']);
            $weight = mysqli_real_escape_string($conn, $data['weight']);
            $guarantee = mysqli_real_escape_string($conn, $data['guarantee']);
            
            $image = $_FILES['image']['name'];
            $target = '../assets/laptops/' . basename($image);
    
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
                $sql = "INSERT INTO products (brand, model, price, screen, ram, processor, model_processor, hard_disc, graphic_card, model_graphic_card, os, weight, guarantee, image_path) VALUES ('$brand', '$model', '$price', '$screen', '$ram', '$processor', '$model_processor', '$hard_disc', '$graphic_card', '$model_graphic_card', '$os', '$weight', '$guarantee', 'assets/laptops/$image')";
                mysqli_query($conn, $sql);
            }
        }
    }
}
?>
