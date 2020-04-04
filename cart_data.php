<?php 

include 'config/database.php';
$getCarts = mysqli_query($connection, 'select * from cart_table');

if (isset($getCarts)) {
    foreach ($getCarts as $getCart) {
        $response[] = $getCart;
    }
} else {
    echo "<p>Item Not Available</p>";
}

echo json_encode($response);
