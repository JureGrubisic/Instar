<?php 
session_start();
include("model/db.php"); 
include("model/user.class.php"); 
include("model/product.class.php"); 
if (!User::jePrijavljen()) header("Location: login.php");

$prijavljeni_korisnik = User::$prijavljeniKorisnik;
if($prijavljeni_korisnik["typeOfUser"] !='administrator'){
    header("Location:login.php");
}

$sql="SELECT * FROM users";
$results=mysqli_query($conn,$sql);
$users=$results->fetch_all(MYSQLI_ASSOC);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href='assets/logo/ls-icon.png'>
    <title>Pc Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/47f0b88d10.js"></script>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</head>

<body>
    
    <div class="modal" tabindex="-1" role="dialog" id="addNewProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Dodavanje proizvoda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="products/add.php" method="POST" id="addUserForm" enctype="multipart/form-data">
                        <div class="row mb-3 gx-3">
                            <div class="form-group col ">
                                <input type="hidden" name="idKorisnika" />
                                <input type="text" name="brand" id="brand" class="form-control form-control-sm" placeholder="Brand" required>
                            </div>
                            <div class="form-group col">                           
                                <input type="text" name="model" id="model" class="form-control form-control-sm" placeholder="Model" required>
                            </div>
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Cijena" required>
                            </div>
                            <div class="form-group col">
                                <input type="text" name="screen" id="screen" class="form-control form-control-sm" placeholder="Veličina ekrana" required>
                            </div>
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="text" name="ram" id="ram" class="form-control form-control-sm" placeholder="RAM" required>
                            </div>
                            <div class="form-group col">
                                <input type="text" name="hard_disc" id="hard_disc" class="form-control form-control-sm" placeholder="Memorija" required>
                            </div>
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="text" name="processor" id="processor" class="form-control form-control-sm" placeholder="Procesor" required>     
                            </div>
                            <div class="form-group col">
                                <input type="text" name="model_processor" id="model_processor" class="form-control form-control-sm" placeholder="Model procesora" required>
                            </div>
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="text" name="graphic_card" id="graphic_card" class="form-control form-control-sm" placeholder="Grafička kartica" required>
                            </div>
                            <div class="form-group col">
                                <input type="text" name="model_graphic_card" id="model_graphic_card" class="form-control form-control-sm" placeholder="Model grafičke kartice" required>
                            </div>
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="text" name="os" id="os" class="form-control form-control-sm" placeholder="OS" required>
                            </div>
                            <div class="form-group col">
                                <input type="text" name="weight" id="weight" class="form-control form-control-sm" placeholder="Težina" required>
                            </div>
                            
                        </div>
                        <div class="row mb-3 gx-3">
                            <div class="form-group col">
                                <input type="number" min="1" max="5" name="guarantee" id="guarantee" class="form-control form-control-sm" placeholder="Garancija" required>
                            </div>
                            <div class="form-group col">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="image">Odaberite sliku</label>
                                    <input type="file" class="custom-file-input" name="image" id="image" aria-describedby="inputGroupFileAddon01">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mr-2"style="float:right;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                            <input type="submit" class="btn btn-primary"></input>                        
                        </div>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="modal" tabindex="-1" role="dialog" id="editProduct">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary">Uređivanje proizvoda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="brand" id="brand" class="form-control form-control-sm" placeholder="Brand" required>
                        </div>
                        <div class="col">
                            <input type="text" name="model" id="model" class="form-control form-control-sm" placeholder="Model" required>
                        </div>
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Cijena" required>
                        </div>
                        <div class="col">
                            <input type="text" name="screen" id="screen" class="form-control form-control-sm" placeholder="Veličina ekrana" required>
                        </div>
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="ram" id="ram" class="form-control form-control-sm" placeholder="RAM" required>
                        </div>
                        <div class="col">
                            <input type="text" name="hard_disc" id="hard_disc" class="form-control form-control-sm" placeholder="Memorija" required>
                        </div>
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="processor" id="processor" class="form-control form-control-sm" placeholder="Procesor" required>     
                        </div>
                        <div class="col">
                            <input type="text" name="model_processor" id="model_processor" class="form-control form-control-sm" placeholder="Model procesora" required>
                        </div>
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="graphic_card" id="graphic_card" class="form-control form-control-sm" placeholder="Grafička kartica" required>
                        </div>
                        <div class="col">
                            <input type="text" name="model_graphic_card" id="model_graphic_card" class="form-control form-control-sm" placeholder="Model grafičke kartice" required>
                        </div>
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="text" name="os" id="os" class="form-control form-control-sm" placeholder="OS" required>
                        </div>
                        <div class="col">
                            <input type="text" name="weight" id="weight" class="form-control form-control-sm" placeholder="Težina" required>
                        </div>
                        
                    </div>
                    <div class="row mb-3 gx-3">
                        <div class="col">
                            <input type="number" name="guarantee" id="guarantee" class="form-control form-control-sm" placeholder="Garancija" required>
                        </div>
                        <div class="col">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Odaberite sliku</label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-primary">Spremi proizvod</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal" tabindex="-1" role="dialog" id="deleteWarning">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Upozorenje!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <p class="text-primary">Da li ste sigurni da želite izbrisati proizvod?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
                <a href="#" id="modalDelete" class="btn btn-primary">Da</a>
            </div>
        </div>
    </div>
</div>
    <nav class="navbar navbar-dark bg-primary fixed-top flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-sm-3 col-md -2 mr-0" href="#">Laptops Shop</a>
            <div class="dropdown" style="right:20px;">
                <div class="dropdown-toggle align-center valign-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo ($prijavljeni_korisnik["firstName"]. " ".$prijavljeni_korisnik["surName"]);?>
                    
                </div>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">
                         Profil
                    </a>
                    <a class="dropdown-item" href="logout.php">
                         Odjava
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid" style="position:relative;top:40px;">
        <div class="row">
            <div class="col-md-2 bg-light d-none d-md-block sidebar">
                <div class="left-sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#pregled">
                                
                                Pregled sustava
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#proizvodi">
                                
                                Proizvodi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a type="button" class="nav-link text-primary" data-toggle="modal" data-target="#addNewProduct">
                                
                                Dodavanje proizvoda
                            </a>
                        </li>                       
                    </ul>
                </div>
            </div>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="container" >
                    <div class="card mt-5" id="pregled" style="scroll-margin-top:80px;">
                        <h5 class="card-header bg-primary" style="color:white;" >Pregled sustava</h5>
                        <div class="card-body">
                            <div class="container">
                                <div class="row" style="width:70%; margin:auto;">
                                    <div class="col-md-4">
                                        <div class="box" style="margin:0 auto;">
                                            <h2 style="color:gray;">
                                                
                                                <?php 
                                                    $sql="SELECT COUNT(*) as total FROM users";
                                                    $result = mysqli_query($conn, $sql);
                                                    $usersCount= mysqli_fetch_assoc($result);
                                                    echo ($usersCount['total']);
                                                ?>
                                            </h2>
                                            <h4 style="color:gray;">Korisnici</h4>                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <h2 style="color:gray;">
                                            
                                            <?php 
                                                $sql="SELECT COUNT(*)as total FROM products ";
                                                $result = mysqli_query($conn, $sql);
                                                $productsCount= mysqli_fetch_assoc($result);
                                                echo ($productsCount['total']);
                                            ?>
                                        </h2>
                                        <h4 style="color:gray;">Proizvodi</h4>                            
                                    </div>
                                    <div class="col-md-4">
                                        <h2 style="color:gray;">
                                            
                                            <?php 
                                                $sql="SELECT COUNT(*)as total FROM orders ";
                                                $result = mysqli_query($conn, $sql);
                                                $productsCount= mysqli_fetch_assoc($result);
                                                echo ($productsCount['total']);
                                            ?>
                                        </h2>
                                        <h4 style="color:gray;">Narudžbe</h4>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card mt-5 " id="proizvodi" style="scroll-margin-top:80px;">
                        <h5 class="card-header bg-primary" style="color:white;">Proizvodi</h5>    
                        <div class="card-body">
                                        
                            <table class="table table-striped ">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" class="text-center">ID</th>
                                        <th scope="col" class="text-center">Slika</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Model</th>                         
                                        <th scope="col">Cijena</th>
                                        <th scope="col">Akcije</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach(Product::getProducts() as $product):
                                    ?>
                                    <tr>
                                        <td class="align-middle text-center"><?=$product['ID']?></td>
                                        <td class="align-middle text-center"><img src="<?=$product['image']?>" alt="" style="width:70px;height:70px;"></td>
                                        <td class="align-middle"><?=$product['brand']?></td>
                                        <td class="align-middle"><?=$product['model']?></td>
                                        <td class="align-middle"><?=$product['price']?> KM</td>
                                        <td class="align-middle">
                                            <a href="#" class="btn btn-success btn-sm rounded-pill editbtn" title="Uređivanje profila">Uredi</a>
                                            <a  type="button" class="btn btn-danger btn-sm rounded-pill text-white delete-product" data-toggle="modal" data-id="<?= $product["ID"] ?>" data-target="#deleteWarning">Izbriši</a>
                                        </td>
                                    </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>    
                        </div>                    
                    </div>   
                </div>

            </main>
        
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#deleteWarning').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                $('#modalDelete').attr('href', 'products/delete.php?id=' + id);
            });
            $('.editbtn').on('click',function(){
                $('#editProduct').modal('show');
                $tr=$(this).closest('tr');
                var data=$tr.children("td").map(function(){
                    return $(this).text();
                }).get();
                console.log(data);
                
            });
        });
        
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <script src="main.js"></script>
</body>
</html>