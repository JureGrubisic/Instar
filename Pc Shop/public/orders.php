<?php
session_start();
include("model/db.php"); 
include("model/user.class.php"); 
include("model/product.class.php"); 
if (!User::jePrijavljen()) header("Location: login.php");

$prijavljeni_korisnik = User::$prijavljeniKorisnik;
if($prijavljeni_korisnik["typeOfUser"] !='korisnik'){
    header("Location:login.php");
}

$result=$conn->query("SELECT * FROM orders WHERE userId=".$prijavljeni_korisnik['ID']);
$orders=$result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href='assets/logo/ls-icon.png'>
    <title>Pc Shop</title>
    <link rel="stylesheet" href="../css/stylee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/47f0b88d10.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/stylee.css">
    <style>
        @media only screen and (max-width: 550px) {
            .box-first>.search-box{
                display:block;
            }
        }
        .box-first>.dropdown{
            position:absolute;
            right:20px;
            color:white;
            margin-top:8px;
        }
        .dropdown-menu>.dropdown-item{
            color:#005DA4;
        }
        .dropdown-menu>.dropdown-item:hover{
            color:#005DA4;
        }
        .main>.container>.row>.second{
            display:none;
        }
        @media only screen and (max-width: 990px){
            .main>.container>.row>.first{
                display:none;
            }
            .main>.container>.row>.second{
                display:block;
            }
        }
        .card-title>a{
            color:#005DA4;            
        }
        .list-group li a{
            text-decoration:none;
        }
        .list-group li a:hover{
            color:black;
        }
        
        
        
    </style>

</head>

<body>
    
    <header>
        <div class="box-first">           
            <div class="search-box" style="left:20px;">
                <input type="text" placeholder="Search...">
                
            </div>
            <div class="dropdown">
                <div class="dropdown-toggle align-center valign-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo ($prijavljeni_korisnik["firstName"]. " ".$prijavljeni_korisnik["surName"]);?>
                    
                </div>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="userProfile.php">
                         Profil
                    </a>
                    <a class="dropdown-item" href="wishList.php">
                        Lista želja
                    </a>
                    <a class="dropdown-item" href="logout.php">
                        Odjava
                    </a>
                </div>
            </div>           
        </div>
        <?php include("static/headerSec.php");?>
    </header>
    <div class="main">
        <div class="animate-text">
            <p><span></span></p>
        </div>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <h3 class="text-primary ml-1">
                        <i class="bi bi-person-circle mr-1 text-secondary" style="font-size: 2.4rem;"></i>
                        <?php echo $prijavljeni_korisnik["firstName"] . " ". $prijavljeni_korisnik["surName"]?>
                    </h3>
                    <ul class="list-group mt-3">
                      <li class="list-group-item"><a href="profile.php">Osobni podaci</a></li>
                      <li class="list-group-item"><a href="changeData.php">Izmjena podataka</a></li>
                      <li class="list-group-item"><a href="changePassword.php">Promjena lozinke</a></li>
                      <li class="list-group-item active"><a href="orders.php" class="text-white">Moje narudžbe</a></li>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-8">
                    <h4 class="ml-3 mt-3 text-primary center">Moje narudžbe</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                <th scope="col" class="text-secondary">Narudžba</th>
                                <th scope="col" class="text-secondary">Vrijeme</th>
                                <th scope="col" class="text-secondary">Datum</th>
                                <th scope="col" class="text-secondary">Proizvodi(količina)</th>
                                <th scope="col" class="text-secondary">Cijena</th>
                                </tr>
                            </thead>
                            <?php foreach($orders as $order):?>
                            <tbody>
                                <tr>
                                <th scope="row" class="text-secondary">#<?= $order["ID"]?></th>
                                <?php $timeDate=explode(" ",$order["orderDate"])?>
                                <td><?= $timeDate[1];?></td>
                                <td><?= $timeDate[0];?></td>
                                <td><?= $order["products"]?></td>
                                <td><?= $order["price"]?> BAM</td>
                                </tr>
                            </tbody>
                            <?php endforeach ?>
                        </table>
                    </div>             
            
                </div>
            </div>
        </div>
        
    </div> 
    <?php include("static/footer.php");?>
    <script>
        $(document).ready(function(){
            
            load_cart_item_number();
            function load_cart_item_number(){
                $.ajax({
                    url:"action.php",
                    method:"get",
                    data:{cartItem:"cart_item"},
                    success:function(response){
                        $("#cart-item").html(response);
                    }
                });
            }

            load_cart_item_number();
            function load_cart_item_number(){
                $.ajax({
                    url:"action.php",
                    method:"get",
                    data:{cartItem:"cart_item"},
                    success:function(response){
                        $("#cart-item").html(response);
                    }
                });
            }
            
        });
            
    </script>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>

</html>
    