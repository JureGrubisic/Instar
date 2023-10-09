<?php
    session_start();
    include("model/db.php"); 
    include("model/user.class.php"); 
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
        <div class="animate-text">
            <p><span></span></p>
        </div>
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-12" id="message"></div>
                <div class="col-lg-4">
                    <h4 class="text-primary">Adresa isporuke</h4>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h6 class="text-dark">Informacije o vašem profilu</h6>
                        </div>
                        <div class="col-4 text-dark">
                            <b>Ime:</b><br><br>
                            <b>Adresa:</b><br><br>
                            <b>E-mail:</b><br><br>
                            <b>Telefon:</b><br><br>

                        </div>
                        <div class="col-8 text-right text-secondary">
                            <?=$prijavljeni_korisnik["firstName"]?> <?=$prijavljeni_korisnik["surName"]?><br><br>
                            <?=$prijavljeni_korisnik["address"]?><br><br>
                            <?=$prijavljeni_korisnik["email"]?><br><br>
                            <?=$prijavljeni_korisnik["phone"]?><br><br>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary btn-block confirmOrder" onclick="return confirm('Jeste li sigurni da želite potvrditi narudžbu?')"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Potvrdi narudžbu</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h4 class="text-primary">Proizvodi</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table  text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Proizvod</th>
                                    <th>Cijena</th>
                                    <th>Količina</th>
                                    <th>Ukupno</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $stmt=$conn->prepare("SELECT * FROM cart WHERE userId=?");
                                    $stmt->bind_param("i",$prijavljeni_korisnik["ID"]);
                                    $stmt->execute();
                                    $result=$stmt->get_result();
                                    $grand_total=0;

                                    while($row=$result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="align-middle text-center"><img src="<?= $row["product_image"]?>" width="50"></td>
                                    <td class="align-middle text-center"><?= $row["product_name"]?></td>
                                    <td class="align-middle text-center"><?= number_format($row["product_price"],2)?> BAM</td>
                                    <td class="align-middle text-center"><?= $row["qty"]?></td>
                                    <td class="align-middle text-center"><?= $row["total_price"]?> BAM</td>
                                </tr>
                                <?php $grand_total += $row['total_price'];?>
                                <?php endwhile?>
                                <tr>
                                    <th colspan="4" class="text-right">Ukupna cijena</th>
                                    <th><b><i class="fas fa-money-bill-alt"></i>&nbsp;&nbsp;<?= number_format($grand_total,2)?> BAM</b></th>
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
            $(".confirmOrder").click(function(){
                var user=<?=$prijavljeni_korisnik["ID"]?>;
                $.ajax({
                    url:"action.php",
                    method:"post",
                    data:{userID:user},
                    success:function(response){
                        $("#message").html(response);
                    }
                });
            });
        });    
        
    </script>
</body>

</html>