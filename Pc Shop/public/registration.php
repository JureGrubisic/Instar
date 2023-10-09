<?php
include ("model/db.php");
if(isset($_POST['btn-reg-confirm'])){
    $email=$conn->real_escape_string($_POST['email']);
    $query="SELECT email FROM users WHERE email = '$email'";
    $result=$conn->query($query);
    if($_POST['firstName'] == "" || $_POST['surName'] == "" ||$_POST['address'] == "" ||$_POST['phone'] == "" || $_POST['email'] == "" || $_POST['password'] == "" || $_POST['password-second'] == ""){
        $error="Molimo ispunite sva polja za unos podataka!";
    }else if($result->num_rows>0){
        $error="Korisnik već postoji!";       
    }else if($_POST["password"] != $_POST["password-second"]){
        $error="Molimo unesite iste lozinke kako bi se registrirali!" ;
    }else if(strlen($_POST['password'])<5){
        $error ="Lozinka mora sadržati barem 5 znakova!";
    }else{
        $sql="INSERT INTO users values(null,'";
        $sql.=$_POST["firstName"] ."','";
        $sql.=$_POST["surName"] ."','";
        $sql.=$_POST["address"] ."','";
        $sql.=$_POST["phone"] ."','";
        $sql.=$_POST["email"] ."','";
        $sql.=md5($_POST["password"]) ."','korisnik')";
        $result=mysqli_query($conn,$sql);
        $message="Uspješno ste se registrirali!";
    }
}
$naslov="Laptops Shop-Registracija";
include("static/header.php");    
?>
    <div class="registration-form">
        <div class="wrapper">
            <form action="registration.php" method="POST">
                <h4>Kreirajte korisnički račun</h4>
                <hr/>
                <?php if(isset($error)):?>
                <div class="alert alert-danger"><?php echo ($error)?></div>
                <?php endif ?>
                <?php if(isset($message)):?>
                <div class="alert alert-success"><?php echo ($message)?></div>
                <?php endif ?>

                <h6>Unesite vaše osobne podatke</h6>
                
                <label for="firstName" class="firstName"><span>*</span>Ime</label><br>
                <input type="text" name="firstName" placeholder="Unesite Vaše ime..."><br>

                <label for="surName" class="surName"><span>*</span>Prezime</label><br>
                <input type="text" name="surName" placeholder="Unesite Vaše prezime..."><br>

                <label for="address" class="address"><span>*</span>Adresa</label><br>
                <input type="text" name="address" placeholder="Unesite Vašu adresu..."><br>

                <label for="phone" class="phone"><span>*</span>Telefon</label><br>
                <input type="text" name="phone" placeholder="Unesite broj Vašeg telefona..."><br>

                <h6>Informacije za prijavu</h6>

                <label for="email" class="email"><span>*</span>E-mail</label><br>
                <input type="email" name="email" id="email" placeholder="Unesite Vašu e-mail adresu..."><br>

                <label for="password" class="password"><span>*</span>Lozinka</label><br>
                <input type="password" name="password" placeholder="Unesite Vašu lozinku..."><br>

                <label for="password-second" class="password-second"><span>*</span>Potvrdite lozinku</label><br>
                <input type="password" name="password-second" placeholder="Potvrdite Vašu lozinku..."><br>
                <div class="checkbox">
                    <label for="confirmatison" class="conf-label">
                    <input type="checkbox" class="conf-input" id="confirmation" name="confirmation" value="confirmation" onchange="checkboxChange()" >
                        Prihvaćam uvjete poslovanja i suglasan/a sam sa korištenjem mojih osobnih podatataka.
                    </label><br>
                </div>
                <br>
                <button type="submit" disabled="true" class="btn btn-primary " id="btn-reg-confirm"  name="btn-reg-confirm">Potvrdi</button>
                
            </form>
        </div>
    </div>

<?php
include("static/footer.php");  
?>
<script src="main.js"></script>