<?php
include "config/database.php";

$json = file_get_contents('php://input');
$data = json_decode($json);
if (isset($data->data)) {

    $query = "select * from products where status = '1'";

    if (!empty($data->category)) {
        $type_filter = implode("','",$data->category);
        $query .= "AND category IN('".$type_filter."')";
    }


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