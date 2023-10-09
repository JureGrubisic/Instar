<?php
session_start();
include("model/db.php"); 
include("model/user.class.php"); 
include("model/product.class.php"); 
if (!User::jePrijavljen()) header("Location: login.php");

$prijavljeni_korisnik = User::$prijavljeniKorisnik;
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
                    <a class="dropdown-item" href="profile.php">
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                <div  style="display:<?php if(isset($_SESSION["showAlert"])){echo $_SESSION["showAlert"];}else{echo 'none';}unset($_SESSION['showAlert']);?>" class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong><?php if(isset($_SESSION["message"])){echo $_SESSION["message"];} unset($_SESSION['showAlert']);?></strong>
                </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <td colspan="7"><h4 class="text-center text-primary m-0">Proizvodi u košarici!</h4></td>                 
                                </tr>
                                <tr>
                                    <th>ID</th>
                                    <th>Slika</th>
                                    <th>Proizvod</th>
                                    <th>Cijena</th>
                                    <th>Količina</th>
                                    <th>Ukupna cijena</th>
                                    <th>
                                        <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Jeste li sigurni da želite isprazniti košaricu?');">
                                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Ispraznite košaricu
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    require "model/db.php";
                                    $stmt=$conn->prepare("SELECT * FROM cart WHERE userId=?");
                                    $stmt->bind_param("i",$prijavljeni_korisnik["ID"]);
                                    $stmt->execute();
                                    $result=$stmt->get_result();
                                    $grand_total=0;
    
                                    while($row=$result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="align-middle text-center"><?=$row["ID"]?></td>
                                    <input type="hidden" class="pid" value="<?=$row["ID"]?>">
                                    <td class="align-middle text-center"><img src="<?=$row["product_image"]?>" width="50"></td>
                                    <td class="align-middle text-center"><?= $row["product_name"]?></td>
                                    <td class="align-middle text-center"><i class="far fa-money-bill-alt"></i>&nbsp;&nbsp;<?= number_format($row["product_price"],2)?> BAM</td>
                                    <input type="hidden" class="pprice" value="<?= $row["product_price"]?>">
                                    <td class="align-middle text-center"><input type="number"  class="form-control itemQty" value="<?=$row["qty"]?>" style="width:75px;"></td>
                                    <td class="align-middle text-center"><i class="far fa-money-bill-alt"></i>&nbsp;&nbsp;<?= number_format($row["total_price"],2)?> BAM</td>
                                    <td class="align-middle text-center">
                                        <a href="action.php?remove=<?= $row["ID"]?>" class="text-danger lead" onclick="return confirm('Jeste li sigurni da želite izbristi proizvod?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $grand_total += $row['total_price'];?>
                                <?php endwhile?>
                                <tr>
                                    <td colspan="3">
                                        <a href="user-login.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Nastavite kupovati</a>
                                    </td>
                                    <td colspan="2"><b>Ukupna cijena</b></td>
                                    <td><b><i class="fas fa-money-bill-alt"></i>&nbsp;&nbsp;<?= number_format($grand_total,2)?> BAM</b></td>
                                    <td>
                                        <a href="checkout.php"  class="btn btn-primary  <?= ($grand_total>1)?"":"disabled";?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Dovršite narudžbu</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <?php include("static/footer.php");?>
    
    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(".itemQty").on("change",function(){
                var $el=$(this).closest("tr");
                var pid=$el.find(".pid").val();
                var pprice=$el.find(".pprice").val();
                var qty=$el.find(".itemQty").val();
                location.reload(true);
                $.ajax({
                    url:"action.php",
                    method:"post",
                    cache:false,
                    data:{qty:qty,pid:pid,pprice:pprice},
                    success:function(response){                      
                        console.log(response);
                    }
                });
            }); 
            
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
            
            $(".addItemBtn").click(function(e){
                e.preventDefault();
                var $form=$(this).closest(".form-submit");
                var pid=$form.find(".pid").val();
                var pname=$form.find(".pname").val();
                var pprice=$form.find(".pprice").val();
                var pimage=$form.find(".pimage").val();
                var user=<?=$prijavljeni_korisnik["ID"]?>;

                $.ajax({
                    url:"action.php",
                    method:"post",
                    data:{pid:pid,pname:pname,pprice:pprice,pimage:pimage,user:user},
                    success:function(response){
                        $("#message").html(response);
                        window.scrollTo(0,0);
                        load_cart_item_number();
                    }
                });

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
            
            
        });
    </script>
</body>

</html>
    