<?php
include 'config/database.php';

$json = file_get_contents('php://input');
$postdata = json_decode($json);

$category = $postdata->category;
echo $category;

if (isset($category) == 'AddItem') {
    echo $postdata->cart_item_add;

    if (isset($postdata->cart_item_add)) {
        $cartId = $postdata->cart_item_add;
        echo $cartId;

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

    if (isset($postdata->cart_item_add)) {
        $cartId = $postdata->cart_item_add;

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
    if (isset($postdata->cart_item_subtract)) {
        $cartId = $postdata->cart_item_subtract;

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
    if (isset($postdata->cart_item_delete)) {
        $cartId = $postdata->cart_item_delete;

        $delete_item_cart = mysqli_query($connection, 'delete from cart_table where id = "'.$cartId.'"');

    }  
}

// include 'layout/footer.php';
?>
