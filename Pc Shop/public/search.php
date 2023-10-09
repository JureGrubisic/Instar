<?php
    session_start();

    include("model/db.php"); 
    include("model/user.class.php"); 
    include("model/product.class.php"); 

    if(isset($_POST["value"])){
        $output='';
        $value=$_POST["value"];
        $value=preg_replace("#[^0-9a-z]#i","",$value);

        $sql="SELECT * FROM products WHERE brand LIKE '%$value%' OR model LIKE '%$value%'";
        $result=$conn->query($sql);
        $count=mysqli_num_rows($result);
        if($count==0){
            $output='<div class="alert alert-danger col-12 alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Nema rezultata pretrage!!</strong> 
                </div>';
        }else{
            while($row=$result->fetch_assoc()){
                $output.='<div class="col-md col-sm-6 mt-5" >
                <div class="card shadow p-1  bg-white rounded" style="width:15rem; height:27rem;margin-left: auto;margin-right: auto;">
                    <img src="'.$row['image'].'" class="card-img-top" style="width:95%;"alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-center" style="color:#005DA4;font-size:17px;">
                            '.$row['brand'].' '.$row['model'].'
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
                </div>
            </div>';
            }
        }
        echo $output;
        
    }

?>    