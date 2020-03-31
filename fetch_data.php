<?php
include "config/database.php";

if (isset($_POST['data'])) {
    $query = "select * from products where status = '1'";

    if (isset($_POST['category'])) {
        $type_filter = implode("','",$_POST["category"]);
        $query .= "AND category IN('".$type_filter."')";
    }

    $allProducts = mysqli_query($connection,$query);
    $response = '';

    if (mysqli_num_rows($allProducts) > 0) {
        foreach ($allProducts as $allProduct) {
            $response .= '
                <div class="card pl-3 pb-3 pt-3 pr-3 ml-5 mb-5 mt-5" style="width: 19rem;"> 
                    <img src="images/'.$allProduct['images'].'" alt="demo" class="card-img-top"> 
                    <hr class="bg-info">
                    <div class="card=body"> 
                        <p class="h5 font-weight-bold"> '.$allProduct['name'].' </p> 
                        <p class="lead text-justify text-muted"> '.$allProduct['details'].' </p> 
                        <p class="h5 text-center font-weight-bold">$ '.$allProduct['price'].' </p> 
                        <div class="text-center"> 
                            <button class="btn btn-info btn-lg rounded-pill button-cart" 
                                id="button-cart" 
                                data-cart-id='.$allProduct["id"].' 
                                data-cart-name='.$allProduct["name"].' 
                                data-cart-details='.$allProduct["details"].' 
                                data-cart-price='.$allProduct["price"].' 
                                data-cart-image='.$allProduct["images"].'
                            >  
                                Add to cart
                            </button> 
                        </div> 
                    </div> 
                </div>
            ';
        }
    }
    else{
        $response = "<h2>Items Not found..!!</h2>";
    }
    echo $response; 
}
?>