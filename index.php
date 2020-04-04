<?php
include 'layout/header.php';
include 'config/database.php';
session_start();

$getCarts = mysqli_query($connection, 'select * from cart_table');
$getCategory = mysqli_query($connection, 'select distinct category from products');
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

if (isset($_POST['discountButton']) && isset($_POST['discountAmount'])) {

    if ($_POST['checkDiscountType'] == 1) {
        $discountAmount = $_POST['discountAmount'];

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

    if ($_POST['checkDiscountType'] == 2) {
        $discountAmount = $_POST['discountAmount'];
        
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

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 border">
            <label class="navbar-header mt-2 h4 font-weight-bold">Cart Manager</label>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <?php foreach ($getCategory as $record) { ?>
                <div class="list-group-item checkbox">
                    <label>
                        <input type="checkbox" 
                            name="hello" 
                            class="common_selector category custom-radio" 
                            value="<?php echo $record['category']; ?>"
                            data-id = "<?php echo $record['category']; ?>"
                        > 
                            <?php echo $record['category']; ?>
                    </label>
                </div>
            <?php } ?>
        </div>

        <div class="col-lg-6 col-md-7 col-sm-6 ">
            <div class="d-inline-flex flex-wrap cart-data">

            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-5">
            <div class="card border-right-0 border-top-0">
                <p class="h4">Cart Details</p>
                <div class="card-body cart-item-data">

                    </div>

                <div class="card-body">

                <form action="" method="post">
                    <div class="form-inline">
                            <div class="input-group">
                                <select class="custom-select mr-2 " name="checkDiscountType">
                                    <option selected value="1">%</option>
                                    <option value="2">$</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <input type="text"
                                    name="discountAmount"
                                    id="discount"
                                    placeholder="Discount"
                                    class="form-control mr-2"
                                >
                            </div>

                            <div class="input-group">
                                <button type="submit"
                                    id="button-discount"
                                    class="btn btn-success"
                                    name="discountButton"
                                >
                                    Apply
                                </button>
                            </div>
                        </div>
                   </form>

                    <hr class="bg-info">

                    <div class="d-block d-flex justify-content-between">
                        <div class="justify-content-start">
                            <p>Subtotal</p>
                            <p><?php echo ($total < 1000) ? "ShippingCharges" : ""; ?></p>
                            <p><?php echo empty($discount) ? "" : "Discount" ?></p>
                            <p>Total</p>
                            <p>Tax</p>
                            <p>Payable</p>
                        </div>

                        <div class="justify-content-end">
                            <p>$<?php echo sprintf('%.2f', $subTotal); ?></p>
                            <p><?php echo ($total < 1000) ? "$".$shippingCharge : "" ; ?></p>
                            <p><?php echo isset($discount) ? "$".$discount : ""; ?></p>
                            <p>$<?php echo $total ?></p>
                            <p>$<?php echo $tax?></p>
                            <p>$<?php echo sprintf('%.2f', $payable) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="all_products">
    <div class="card pl-3 pb-3 pt-3 pr-3 ml-5 mb-5 mt-5" style="width: 19rem;"> 
        <img alt="demo" class="card-img-top product-image"> 
        <hr class="bg-info">
        <div class="card=body"> 
            <p class="h5 font-weight-bold product-name"> </p> 
            <p class="lead text-justify text-muted product-details"></p> 
            <p class="h5 text-center font-weight-bold product-price">$</p> 
            <div class="text-center"> 
                <button class="btn btn-info btn-lg rounded-pill button-cart" 
                    id="button_cart" 
                    data-cart-id='' 
                >  
                    Add to cart
                </button> 
            </div> 
        </div> 
    </div>
</template>

<template id="cart_item_products">
    <img src="" alt="demo" class="card-img-top cart-image" style="width:100px;">
    <div class="d-flex justify-content-between">
        <p class="h5 text-muted cart-name"></p>
        <p class="h6 text-muted text-truncate cart-details"></p>
    </div>

    <div class="row justify-content-end">
        <p class="h5 text-muted cart-price">$</p>
    </div>

    <div class="d-flex justify-content-end">
        <input type="number" 
            name="qty" 
            class="form-control quantity disable border-0 bg-white" 
            id="quantity"
            value="" 
            readonly
        >

        <button class="btn btn-secondary btn-sm ml-2 mr-2 cart-item-add" data-cart-id="">
            <span class="fa fa-plus"></span>
        </button>

        <button class="btn btn-secondary btn-sm mr-2 cart-item-subtract" data-cart-id="">
            <span class="fa fa-minus"></span>
        </button>

        <button class="btn btn-danger cart-item-delete btn-sm" data-cart-id="">
            <span class="fa fa-trash"></span>
        </button>
    </div>

    <hr class="bg-info">
</template>
<?php
    include 'layout/footer.php';
?>