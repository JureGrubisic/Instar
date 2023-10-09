<?php
session_start();

include("model/db.php");

if(isset($_POST["btn-login-confirm"])){
    if($_POST['email-login']==""){
        $error="Molimo unseite e-mail adresu";
    }else if($_POST['password-login']==""){
        $error="Molimo unesite vašu lozinku";
    }else{
        $sql="SELECT * FROM users WHERE ";
        $sql.="email='".$_POST['email-login']."' AND ";
        $sql.="password='".md5($_POST['password-login'])."'";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==0){
            $error="Vaši korisnički podaci nisu ispravni molimo pokušajte ponovo.";
        }else{
            $user=mysqli_fetch_assoc($result);
            $type=$user["typeOfUser"];
            $_SESSION["token"]=$user["ID"];
            if($type=='korisnik'){
                header("Location:user-login.php");
            }else if($type=='administrator'){
                header("Location:admin-login.php");
            }else if($type=='superadministrator'){
                header("Location:superadmin-login.php");
            }else{
                header("Location:login.php");
            }
            
        }
    }
}

$naslov="Laptops Shop-Prijava";
include("static/header.php");
?>


    <div class="login-form">
        <div class="wrapper">
            <form action="login.php" method="POST">
                <h4>Prijavite se</h4>
                <hr/>
                <?php if(isset($error)):?>
                <div class="alert alert-danger"><?php echo ($error)?></div>
                <?php endif ?>

                <label for="email-login" class="email-login"><span>*</span>E-mail</label><br>
                <input type="email" name="email-login" id="email-login" placeholder="Unesite vašu e-mail adresu..."><br>

                <label for="password-login" class="password-login"><span>*</span>Lozinka</label><br>
                <input type="password" name="password-login" id="password-login" placeholder="Unesite vašu lozinku..."><br>

                <button type="submit" class="btn btn-primary" id="btn-login-confirm" name="btn-login-confirm">Potvrdi</button>
            </form>
        </div>
    </div>

<?php
include("static/footer.php");
?>