<?php
include "config/database.php";

if (isset($_POST['data'])) {
    $query = "select * from products where status = '1'";

    $allProducts = mysqli_query($connection,$query);

    if (mysqli_num_rows($allProducts) > 0) {
        foreach ($allProducts as $allProduct) {
            $response[] = $allProduct;
        }
    }
    else{
        $response = "<h2>Items Not found..!!</h2>";
    }
    echo json_encode($response); 
}
?>