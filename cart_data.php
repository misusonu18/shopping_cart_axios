<?php 

include 'config/database.php';
$getCarts = mysqli_query($connection, 'select * from cart_table');

if (isset($getCarts)) {
    foreach ($getCarts as $getCart) {
?>
    <img src="<?php echo 'images/'.$getCart['cart_image'] ?>" alt="demo" class="card-img-top" style="width:100px;">
    <div class="d-flex justify-content-between">
        <p class="h5 text-muted"><?php echo $getCart['cart_name'] ?></p>
        <p class="h6 text-muted text-truncate"><?php echo $getCart['cart_details']; ?></p>
    </div>

    <div class="row justify-content-end">
        <p class="h5 text-muted">$<?php echo $getCart['cart_price'] ?></p>
    </div>

    <div class="d-flex justify-content-end">
        <input type="number" name="qty" class="form-control quantity disable border-0 bg-white" id="quantity"
            value="<?php echo $getCart['cart_quantity'] ?>" readonly>

        <button class="btn btn-secondary btn-sm ml-2 mr-2 cart-item-add" data-cart-id="<?php echo $getCart['id']; ?>">
            <span class="fa fa-plus"></span>
        </button>

        <button class="btn btn-secondary btn-sm mr-2 cart-item-subtract" data-cart-id="<?php echo $getCart['id']; ?>">
            <span class="fa fa-minus"></span>
        </button>

        <button class="btn btn-danger cart-item-delete btn-sm" data-cart-id="<?php echo $getCart['id']; ?>">
            <span class="fa fa-trash"></span>
        </button>
    </div>

    <hr class="bg-info">

<?php
    }
} else {
    echo "<p>Item Not Available</p>";
}
