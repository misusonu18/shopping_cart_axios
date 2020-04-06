<?php
include 'config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$getCarts = mysqli_query($connection, 'select * from cart_table');

$subTotal = 0.00;
$discountError = 0;

if (isset($subTotal)) {
    foreach ($getCarts as $records) {
        $subTotal = $subTotal + $records['cart_quantity'] * $records['cart_price'];
    }
    $shippingCharge = $subTotal < 1000 ? 100 : 0;
    $total = $subTotal + $shippingCharge;
    $tax = 18;
    $payable = floor($total) + $tax;
}
if (empty($subTotal)) {
    $shippingCharge = 0;
    $tax = 0.00;
    $total = 0.00;
    $payable = 0.00;
}

if (!empty($data->discount_amount) && !empty($data->discount_type)) {
    if ($data->discount_type == 1) {
        $discountAmount = $data->discount_amount;

        if ($subTotal > 500 && $subTotal < 5000) {
            if ($discountAmount <= 15) {
                $discount = floatval(($discountAmount / 100) * $subTotal);
                $total = $subTotal - $discount;
                $shippingCharge = $total < 1000 ? 100 : 0;
                $tax = 18;
                $payable = $total + $tax;
            }
        }

        if ($subTotal > 5000 && $subTotal < 10000 ) {

            if ($discountAmount <= 25) {
                floatval($discount = ($discountAmount / 100) * $subTotal);
                $total = $subTotal - $discount;
                $shippingCharge = $total < 1000 ? 100 : 0;
                $tax = 18;
                $payable = $total + $tax;
            }
            else {
                $discountError = 1;
            }

        }
        if ($subTotal >= 10000 && $subTotal < 20000) {

            if ($discountAmount <= 35) {
                floatval($discount = ($discountAmount / 100) * $subTotal);
                $total = $subTotal - $discount;
                $shippingCharge = $total < 1000 ? 100 : 0;
                $tax = 18;
                $payable = $total + $tax;
            }

        }

        if ($discountAmount >= 55) {
            $discountError = 1;
        }
    }

    if ($data->discount_type == 2) {
        $discountAmount = $data->discount_amount;
        
        if ($subTotal == $discountAmount) {
            $discountError = 1;
        }

        if ($discountAmount <= 800 && $subTotal > 5000) {
            $discount = $discountAmount;
            $total = $subTotal - $discount;
            $shippingCharge = $total < 1000 ? 100 : 0;
            $tax = 18;
            $payable = $total + $tax;
        }

        if ($discountAmount <= 350 && $subTotal > 500) {
            $discount = $discountAmount;
            $total = $subTotal - $discount;
            $shippingCharge = $total < 1000 ? 100 : 0;
            $tax = 18;
            $payable = $total + $tax;
        }

        if ($discountAmount <= 1000 && $subTotal > 10000) {
            $discount = $discountAmount;
            $total = $subTotal - $discount;
            $shippingCharge = $total < 1000 ? 100 : 0;
            $tax = 18;
            $payable = $total + $tax;
        }

    }
}

$amount_array['subtotal'] = '$'.$subTotal;
$amount_array['tax'] = '$'.$tax;
$amount_array['shippingcharge'] = '$'.$shippingCharge;
$amount_array['discount'] = isset($discount) ? '$'.$discount : "";
$amount_array['total'] = '$'.$total;
$amount_array['payable'] = '$'.$payable;

echo json_encode($amount_array);