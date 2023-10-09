<?php
    session_start();

    include("model/db.php"); 
    include("model/user.class.php"); 
    include("model/product.class.php"); 
    if (!User::jePrijavljen()) header("Location: login.php");

    $prijavljeni_korisnik = User::$prijavljeniKorisnik;
    
    if(isset($_POST["action"])){
        $sql="SELECT * FROM products WHERE brand !=''";
        
        if(isset($_POST['brand'])){
            $brand=implode("','",$_POST['brand']);
            $sql .="AND brand IN('".$brand."')";
        }
        
        if(isset($_POST['ram'])){
            $ram=implode("','",$_POST['ram']);
            $sql .="AND ram IN('".$ram."')";
        }

        if(isset($_POST['hard_disc'])){
            $hard_disc=implode("','",$_POST['hard_disc']);
            $sql .="AND hard_disc IN('".$hard_disc."')";
        }
        if(isset($_POST['processor'])){
            $processor=implode("','",$_POST['processor']);
            $sql .="AND processor IN('".$processor."')";
        }
        if(isset($_POST['screen'])){
            $screen=implode("','",$_POST['screen']);
            $sql .="AND screen IN('".$screen."')";
        }
        if(isset($_POST['graphic_card'])){
            $graphic_card=implode("','",$_POST['graphic_card']);
            $sql .="AND graphic_card IN('".$graphic_card."')";
        }

        if(isset($_POST['os'])){
            $os=implode("','",$_POST['os']);
            $sql .="AND os IN('".$os."')";
        }
        
        $result=$conn->query($sql);
        $output='';

        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $output .= '
                    <div class="col-md-4 mb-2">
                        <div class="card shadow p-1  bg-white rounded" style="width:15rem; height:30rem;margin-left: auto;margin-right: auto;">
                            <img src="'.$row['image'].'" class="card-img-top" style="width:95%;"alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center" style="color:#005DA4;font-size:17px;">
                                    <a href="product-profile.php?id='.$row['ID'].'">'.$row['brand'].' '.$row['model'].'</a>
                                </h5>
                                <p class="card-text">
                                    <ul style="list-style-type:square;font-size:12px;color:gray;" >
                                        <li class="ml-3">'.$row['processor'].'</li>
                                        <li class="ml-3">'.$row['ram'].'</li>
                                        <li class="ml-3">'.$row['hard_disc'].'</li>
                                        <li class="ml-3">'.$row['graphic_card'].' '.$row['model_graphic_card'].'</li>
                                    </ul>
                                    <p class="text-center font-italic"style="color:red;text-decoration:underline; ">'.$row['price'].' BAM</p>
                                </p>
                            </div>
                            <div class="card-footer">
                                <form class="form-submit">
                                    <input type="hidden" class="pid" value="'.$row['ID'].'">
                                    <input type="hidden" class="pname" value="'.$row['brand'].' '.$row['model'].'">
                                    <input type="hidden" class="pprice" value="'.$row['price'].'">
                                    <input type="hidden" class="pimage" value="'.$row['image'].'">
                                    
                                    <button class="btn btn-primary btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Dodaj u košaricu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            }   
        }else{
            $output.="<h3>No products found!</h3>";
        } 
        echo $output;
    }
    if(isset($_POST["pid"])){
        $pid=$_POST["pid"];
        $pname=$_POST["pname"];
        $pprice=$_POST["pprice"];
        $pimage=$_POST["pimage"];
        $user=$_POST["user"];
        $pqty=1;

        $stmt=$conn->prepare("SELECT product_id FROM cart WHERE product_id=? AND userId=?");
        $stmt->bind_param("ii",$pid,$user);
        $stmt->execute();
        $res=$stmt->get_result();
        $r=$res->fetch_assoc();
        
        if(!$r){
            $query=$conn->prepare("INSERT INTO cart(product_name,product_price,product_image,qty,total_price,product_id,userid) VALUES (?,?,?,?,?,?,?)");
            $query->bind_param("sssisii",$pname,$pprice,$pimage,$pqty,$pprice,$pid,$user);
            $query->execute();

            echo '<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Proizvod dodan u košaricu!</strong> 
                </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Proizvod je već dodan u košaricu!</strong> 
                </div>';
        }
    }
    if(isset($_GET["cartItem"]) && isset($_GET["cartItem"])=='cart_item'){
        $stmt=$conn->prepare("SELECT * FROM cart WHERE userID=?");
        $stmt->bind_param("i",$prijavljeni_korisnik["ID"]);
        $stmt->execute();
        $stmt->store_result();
        $rows=$stmt->num_rows;

        echo $rows;
    }
    
    if(isset($_GET["clear"])){
        $stmt=$conn->prepare("DELETE  FROM cart WHERE userId=?");
        $stmt->bind_param("i",$prijavljeni_korisnik["ID"]);
        $stmt->execute();

        $_SESSION["showAlert"]="block";
        $_SESSION["message"]="Svi proivodi su obrisani!";
        header("Location:card.php");
    }
    if(isset($_GET["remove"])){
        $id=$_GET["remove"];
        $stmt=$conn->prepare("DELETE FROM cart WHERE ID=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();

        $_SESSION["showAlert"]="block";
        $_SESSION["message"]="Proizvod je izbrisan!";
        header("Location:card.php");

    }
    if(isset($_GET["removeFromWishList"])){
        $id=$_GET["removeFromWishList"];
        $stmt=$conn->prepare("DELETE FROM wishlist WHERE idProduct=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
       
        header("Location:wishList.php");

    }
    if(isset($_POST["qty"])){
        $qty=$_POST["qty"];
        $pid=$_POST["pid"];
        $pprice=$_POST["pprice"];

        $tprice=$qty*$pprice;

        $stmt=$conn->prepare("UPDATE cart SET qty=?,total_price=? WHERE ID=?");
        $stmt->bind_param("isi",$qty,$tprice,$pid);
        $stmt->execute();
    }
    if(isset($_POST["userID"])){
        $user=$_POST["userID"];
        $grand_total=0;
        $currentDate = date('Y-m-d H:i:s');
        $allItems='';
        $items=array();

        $sql="SELECT CONCAT(product_name,'(',qty,')') AS ItemQty, total_price FROM cart WHERE userId=".$user;
        $stmt=$conn->prepare($sql);
        $stmt->execute();

        $result=$stmt->get_result();
        while($row=$result->fetch_assoc()){
            $grand_total+=$row['total_price'];
            $items[]=$row['ItemQty'];
        }
        $allItems=implode(", ",$items);

        $query=$conn->prepare("INSERT INTO orders(price,orderDate,userId,products) VALUES (?,?,?,?)");
        $query->bind_param("ssis",$grand_total,$currentDate,$user,$allItems);
        $query->execute();

        $stmt=$conn->prepare("DELETE  FROM cart WHERE userId=?");
        $stmt->bind_param("i",$user);
        $stmt->execute(); 

        echo '<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Vaša narudžba je dovršena! Hvala na povjerenju!</strong> 
                </div>';                      
    }
    if(isset($_POST["productID"])){
        $productID=$_POST["productID"];
        $uID=$_POST["uID"];

        $sql=$conn->prepare("SELECT ID FROM wishlist WHERE idUser=? AND idProduct=?");
        $sql->bind_param("ii",$uID,$productID);
        $sql->execute();
        $results=$sql->get_result();
        $res=$results->fetch_assoc();

        if(!$res){
            $query=$conn->prepare("INSERT INTO wishlist(idUser,idProduct) VALUES (?,?)");
            $query->bind_param("ii",$uID,$productID);
            $query->execute();

            echo '<div class="alert alert-success alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Proizvod dodan u listu želja!</strong> 
                </div>';
        }else{
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Proizvod je već dodan u listu želja!!</strong> 
                </div>';
        }
    }
?>    