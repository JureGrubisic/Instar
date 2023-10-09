<?php
include ("model/db.php");
$id=$_GET['id'];
$sql="SELECT * FROM products WHERE ID=".$id;
$result=$conn->query($sql);
$row=$result->fetch_assoc();
    

session_start();
if (!isset($_SESSION["token"])) header("Location: login.php");
$id = $_SESSION["token"];
$upit = "SELECT * FROM users WHERE ID=".$id;
$result = mysqli_query($conn, $upit);
$prijavljeni_korisnik = mysqli_fetch_assoc($result);  

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href='assets/logo/ls-icon.png'>
    <title>Pc Shop</title>
    <link rel="stylesheet" href="css/stylee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/47f0b88d10.js"></script>

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
            text-decoration:underline;
        }
        .col-md-5>img{
            display:flex;
            align-items:center;
            justify-content: space-between;
            margin:5px auto;
        }
        table>tbody>tr>th{
            border: 1px solid #dfe6e9;
            width:20%;
            color:black;
            font-weight:normal;
            font-style:italic;
        }
        table>tbody>tr>td{
            color:gray;
            font-style:italic;
        }
        .col-md-4>.row>.col-6>img{
            display:flex;
            align-items:center;
            justify-content: space-between;
            margin:1px auto;
        }
        .col-md-4>.row>.col-6>.text{
            font-weight:bold;
            color:#005DA4;
        }
        .boxspec{
            padding-top:30px;
            border:2px solid gray;
            margin-top:30px;
            border-radius:20px;
        }
        .boxspec > .form-submit >.btn{
            display:flex;
            align-items:center;
            justify-content: space-between;
            margin:5px auto;
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
                    <a class="dropdown-item" href="product-profile.php">
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
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-3" id="message"></div>
                <div class="col-md-5">
                    <img src="<?=$row['image']?>" alt="" style="width:300px;height:300px;"/>
                    <h3 class="text-center" style="color:#005DA4;"><?=$row['brand']?> <?=$row['model']?></h3>               
                </div>
                <div class="col-md-4">
                    <div class="row mt-5">
                        <div class="col-6">
                            <img src="assets/images/television.png" alt="" />
                            <p class="text-center">Ekran</p>
                            <p class="text-center text"><?=$row['screen']?></p>
                        </div>
                        <div class="col-6" >
                            <img src="assets/images/cpu.png" alt="" />
                            <p class="text-center">Procesor</p>
                            <p class="text-center text"><?=$row['processor']?></p>
                        </div>
                        <div class="col-6">
                            <img src="assets/images/ram.png" alt="" />
                            <p class="text-center">RAM</p>
                            <p class="text-center text"><?=$row['ram']?></p>
                        </div>
                        <div class="col-6">
                            <img src="assets/images/data-storage.png" alt="" />
                            <p class="text-center">Memorija</p>
                            <p class="text-center text"><?=$row['hard_disc']?></p>
                        </div>    
                                        
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="boxspec mt-5">
                        <form class="form-submit">
                            <input type="hidden" class="productID" value="<?=$row['ID'] ?>">
                            <p class="text-center "> Cijena: <span class="text-danger"><?=$row['price']?> KM</span></p>
                            <button class="btn btn-light border mb-4 addToWistList"><i class="fas fa-list"></i>&nbsp;&nbsp;Lista želja</button>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <table class="table table-striped border mt-5">
                        <tbody>
                            <tr>
                                <th scope="row">Naziv laptopa</th>
                                <td scope="col"><?=$row['brand']?> <?=$row['model']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Veličina ekrana</th>
                                <td scope="col"><?=$row['screen']?> Inch</td>                
                            </tr>
                            <tr>
                                <th scope="row">Procesor</th>
                                <td scope="col"><?=$row['processor']?> <?=$row['model_processor']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">RAM</th>
                                <td scope="col"><?=$row['ram']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Hard disk</th>
                                <td scope="col"><?=$row['hard_disc']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Grafička kartica</th>
                                <td scope="col"><?=$row['graphic_card']?> <?=$row['model_graphic_card']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Operacijski sustav</th>
                                <td scope="col"><?=$row['os']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Težina</th>
                                <td scope="col"><?=$row['weight']?></td>                
                            </tr>
                            <tr>
                                <th scope="row">Garancija</th>
                                <td scope="col"><?=$row['guarantee']?> godine</td>                
                            </tr>
                            <tr>
                                <th scope="row">Cijena</th>
                                <td scope="col"><?=$row['price']?> KM</td>                
                            </tr>
                            
                        </tbody>
                    </table>
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
            $(".addToWistList").click(function(e){
                e.preventDefault();
                var $form=$(this).closest(".form-submit");
                var productID=$form.find(".productID").val();
                var uID=<?=$prijavljeni_korisnik["ID"]?>;
                $.ajax({
                    url:"action.php",
                    method:"post",
                    data:{productID:productID,uID:uID},
                    success:function(response){
                        $("#message").html(response);
                    }
                });
            });
            
        });
    </script>
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
</body>
</html>