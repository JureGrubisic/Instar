<?php

class User{
    public static $prijavljeniKorisnik;

    public static function jePrijavljen(){
        global $conn;
        $id = $_SESSION["token"];
        $upit = "SELECT * FROM users WHERE ID=".$id;
        $rezultat = mysqli_query($conn, $upit);
        self::$prijavljeniKorisnik = mysqli_fetch_assoc($rezultat);
        if (self::$prijavljeniKorisnik) {
            return true;
        }
        return false;
    }
    public static function deleteUser ($id) {
        global $conn;
        $id=intval($id);
        $sql="DELETE FROM users WHERE ID=".$id;
        return mysqli_query($conn, $sql);
    }
    public static function addUser(){
        global $conn;
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $typeOfUser=$_POST['typeOfUser'];
        $sql="INSERT INTO users VALUES (null,'".$firstName."','".$lastName."','".$address."','".$phone."','".$email."','".$password."','".$typeOfUser."')";
        $result=mysqli_query($conn,$sql);
    }
    public static function updateUser(){
        global $conn;
        $id=$_POST['update_id'];
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $typeOfUser=$_POST['typeOfUser'];

        $sql="UPDATE users SET firstName='$firstName',surName='$lastName',address='$address',phone='$phone',email='$email',password='$password',typeOfUser='$typeOfUser' WHERE ID=".$id;
        $result=mysqli_query($conn,$sql);
    }
    public static function updateUserProfile(){
        global $conn;
        $id=$_POST['update_id'];
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        
        $sql="UPDATE users SET firstName='$firstName',surName='$lastName',address='$address',phone='$phone',email='$email' WHERE ID='$id'" ;
        $result=mysqli_query($conn,$sql);
    }
    public static function updateUserPassword(){
        global $conn;

        $id=$_POST['update_id'];
        $currentPassword=$_POST['currentPassword'];
        $currentPasswordConfirm=md5($_POST['currentPasswordConfirm']);
        $newPassword=md5($_POST['newPassword']);
        $confirmNewPassword=md5($_POST['confirmNewPassword']);
        
        $sql="UPDATE users SET password='$newPassword' WHERE ID='$id'" ;
        $result=mysqli_query($conn,$sql);
        return '<script>alert("Uspješno ste promijenili lozinku")</script>';
        // if($currentPassword == $currentPasswordConfirm && $currentPasswordConfirm !=""  && $newPassword !="" && $confirmNewPassword !=""){

        // }
    }
}
?>