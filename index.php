<?php
include 'layout/header.php';
include 'config/database.php';
session_start();

$getCategory = mysqli_query($connection, 'select distinct category from products');

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
                            onclick="categoryOnChnage()"
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
                <p class="h4 mt-3 ml-3">Cart Details</p>
                <div class="card-body cart-item-data">

                    </div>

                <div class="card-body">

                <div class="form-inline">
                        <div class="input-group">
                            <select class="custom-select discount-type mr-2" name="checkDiscountType" id="check_discount_type">
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
                                id="button_discount"
                                class="btn btn-success"
                                name="discountButton"
                                onclick="totalDisplay()"
                            >
                                Apply
                            </button>
                        </div>
                </div>

                    <hr class="bg-info">

                    <div class="d-block d-flex justify-content-between cart_payment">
                        <div class="justify-content-start">
                            <p id="sub_total_name"></p>
                            <p id="shipping_charge_name"></p>
                            <p id="discount_name"></p>
                            <p id="total_name"></p>
                            <p id="tax_name"></p>
                            <p id="payable_name"></p>
                        </div>

                        <div class="justify-content-end">
                            <p id="sub_total"></p>
                            <p id="shipping_charge"></p>
                            <p id="discount_amount_cart"></p>
                            <p id="total"></p>
                            <p id="tax"></p>
                            <p id="payable"></p>
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
                    onclick="productAddButtonClick(this.getAttribute('data-cart-id'))" 
                >  
                    Add to cart
                </button> 
            </div> 
        </div> 
    </div>
</template>

<template id="cart_item_empty_product">
    <p class="message_cart_empty alert alert-danger"></p>
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

        <button class="btn btn-secondary btn-sm ml-2 mr-2 cart-item-add" data-cart-id="" onclick="productUpdateButtonClick(this.getAttribute('data-cart-id'))">
            <span class="fa fa-plus"></span>
        </button>

        <button class="btn btn-secondary btn-sm mr-2 cart-item-subtract" data-cart-id="" onclick="productSubtractButtonClick(this.getAttribute('data-cart-id'))">
            <span class="fa fa-minus"></span>
        </button>

        <button class="btn btn-danger cart-item-delete btn-sm" data-cart-id="" onclick="productDeleteButtonClick(this.getAttribute('data-cart-id'))">
            <span class="fa fa-trash"></span>
        </button>
    </div>

    <hr class="bg-info">
</template>
<?php
    include 'layout/footer.php';
?>