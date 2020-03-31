<?php
include 'config/database.php';


print_r($_POST['data']);

// $category = $_POST['category'];

if (isset($category) == 'AddItem') {

    if (isset($_POST['cart_id_add'])) {
        $cartId = $_POST['cart_id_add'];

        $checkCart = mysqli_query($connection,'select * from cart_table where cart_id = "'.$cartId.'"');
        $productRecords = mysqli_query($connection,'select * from products where id = "'.$cartId.'"');

        if (mysqli_num_rows($checkCart) > 0) {
            $quantity = 1;
            foreach ($checkCart as $cart) {
                $quantity += $cart['cart_quantity'];
            }

            $insert = mysqli_query($connection,'update cart_table set cart_quantity = "'.$quantity.'" where cart_id = "'.$cartId.'"');
        }
        else {

            foreach ($productRecords as $record) {
                $insert = mysqli_query($connection,'insert into cart_table values(0,"'.$cartId.'","'.$record['name'].'","'.$record['details'].'","'.$record['price'].'",1,"'.$record['images'].'")');
            }
        } 
    }

}

if (isset($category) == 'UpdateItem') {

    if (isset($_POST['cart_item_add'])) {
        $cartId = $_POST['cart_item_add'];

        $checkCart = mysqli_query($connection, 'select * from cart_table where id = "'.$cartId.'"');

        if (mysqli_num_rows($checkCart) > 0) {
            $quantity = 1;
            foreach ($checkCart as $cart) {
                $quantity += $cart['cart_quantity'];
            }
            echo $quantity;
            $insert = mysqli_query($connection, 'update cart_table set cart_quantity = "'.$quantity.'" where id = "'.$cartId.'"');
        }
    }

}

if (isset($category) == "SubtractItem") {
    if (isset($_POST['cart_item_subtract'])) {
        $cartId = $_POST['cart_item_subtract'];

        $checkCart = mysqli_query($connection, 'select * from cart_table where id = "'.$cartId.'"');

        if (mysqli_num_rows($checkCart) > 0) {
            $quantity = 1;
            foreach ($checkCart as $cart) {
                $quantity = $cart['cart_quantity'] - $quantity;
                if($cart['cart_quantity'] > 1) {
                    $insert = mysqli_query($connection, 'update cart_table set cart_quantity = "'.$quantity.'" where id = "'.$cartId.'"');
                }
                else {
                    $delete_item_cart = mysqli_query($connection, 'delete from cart_table where id = "'.$cartId.'"');
                }
            }
        }
    }
}

if (isset($category) == "DeleteItem") {
    if (isset($_POST['cart_item_delete'])) {
        $cartId = $_POST['cart_item_delete'];

        $delete_item_cart = mysqli_query($connection, 'delete from cart_table where id = "'.$cartId.'"');

    }  
}

// include 'layout/footer.php';
?>
