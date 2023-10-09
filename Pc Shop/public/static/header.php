<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href='assets/logo/icon.png'>
    <title><?php echo($naslov)?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/47f0b88d10.js"></script>
    <link rel="stylesheet" href="css/stylee.css">
</head>

<body>
    <header>
        <div class="box-first">
            <div class="log-reg">
                <button type="button" class="btn btn-light btn-sm"><a href="login.php">Prijavi se</button>
                <button type="button" class="btn btn-light btn-sm"><a href="registration.php">Registriraj se</a></button>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                
            </div>
            
        </div>
        <div class="box-second">
            <div class="logo">
                <a><img src="assets/logo/icon.png" href="index.php"></a>
            </div>
            
            <div class="search-shopping-box">
                <a href="card.php">
                    <i class="fa fa-shopping-cart mt-4 mr-4"  style='font-size:30px;color:#005DA4;'><span id="cart-item" class="badge badge-danger"style="width:20px;height:20px;font-size:14px;">0</span></i>
                </a>
            </div>
        </div>

        <div class="box-second-smaller">
            <div class="menu" onclick="myFunction(this)">
                <div class="bar1 "></div>
                <div class="bar2 "></div>
                <div class="bar3 "></div>
            </div>
            <div class="logo">
                <a href="index.php"><i class="logo-ls "></i></a>
            </div>
            <div class="search-shopping-box ">
                <a href="card.php">
                    <i class="fa fa-shopping-cart mt-4 mr-4"  style='font-size:30px;color:#005DA4;'><span id="cart-item" class="badge badge-danger"style="width:20px;height:20px;font-size:14px;">0</span></i>
                </a>
            </div>
        </div>
        

        <div class="box-second-smallest">
            <div class="menu" onclick="myFunctionSec(this)">
                <div class="bar1 "></div>
                <div class="bar2 "></div>
                <div class="bar3 "></div>
            </div>
            <div class="logo ">
                <a href="index.php"><i class="logo-ls "></i></a>
            </div>
            <div class="search-shopping-box">
                <a href="card.php">
                    <i class="fa fa-shopping-cart mt-4 mr-4"  style='font-size:30px;color:#005DA4;'><span id="cart-item" class="badge badge-danger"style="width:20px;height:20px;font-size:14px;">0</span></i>
                </a>

            </div>

        </div>
        
    </header>