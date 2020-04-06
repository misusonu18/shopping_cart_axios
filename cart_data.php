<?php 

include 'config/database.php';
$getCarts = mysqli_query($connection, 'select * from cart_table');

if (isset($getCarts)) {
    if (mysqli_num_rows($getCarts)) {
        foreach ($getCarts as $getCart) {
            $response[] = $getCart;
        }
    }
    else {
        $response = "Cart Is Empty";
    }
}

echo json_encode($response);
