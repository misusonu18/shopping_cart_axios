alertify.set('notifier', 'position', 'top-center');

function fetchDataCart() {
    var category = get_category('category');
    var data = 'data';

    axios({
        url:'fetch_data.php', 
        method:'POST',
        data: {data:data, category: category},
      })
      .then(function (response) {
        var record = response.data;
        var htmldata = document.getElementById('all_products');
        var content = htmldata.content.querySelector('.card');

        document.querySelector('.cart-data').innerHTML = '';
        for (let i = 0; i < record.length; i++) {
            htmldata.content.querySelector('.product-image').src = 'images/'+record[i]['images'];
            htmldata.content.querySelector('.product-name').textContent = record[i]['name'];
            htmldata.content.querySelector('.product-details').textContent = record[i]['details'];
            htmldata.content.querySelector('.product-price').textContent = record[i]['price'];
            htmldata.content.querySelector('.button-cart').setAttribute('data-cart-id',record[i]['id']);
            let clone = document.importNode(htmldata.content,true);
            document.querySelector('.cart-data').appendChild(clone);
        }
      });
}

function cartItemData() {
    axios({
        url:'cart_data.php',
        method:'post',
    })
    .then(function(response){
        if (response.data == 'Cart Is Empty') {
            var cartrecord = response.data;
            var carthtmldata = document.getElementById('cart_item_empty_product');
            
            document.querySelector('.cart-item-data').innerHTML = "";

            carthtmldata.content.querySelector('.message_cart_empty').textContent = cartrecord;
            let clone = document.importNode(carthtmldata.content, true); 
            document.querySelector('.cart-item-data').appendChild(clone);
        }
        else {
            var cartrecord = response.data;
            var carthtmldata = document.getElementById('cart_item_products');

            document.querySelector('.cart-item-data').innerHTML = "";
            for (let i = 0; i < cartrecord.length; i++) {
                carthtmldata.content.querySelector('.cart-image').src = 'images/'+cartrecord[i]['cart_image'];
                carthtmldata.content.querySelector('.cart-name').textContent = cartrecord[i]['cart_name'];
                carthtmldata.content.querySelector('.cart-details').textContent = cartrecord[i]['cart_details'];
                carthtmldata.content.querySelector('.cart-price').textContent = cartrecord[i]['cart_price'];
                carthtmldata.content.querySelector('.quantity').setAttribute('value',cartrecord[i]['cart_quantity']);
                carthtmldata.content.querySelector('.cart-item-add').setAttribute('data-cart-id',cartrecord[i]['id']);
                carthtmldata.content.querySelector('.cart-item-subtract').setAttribute('data-cart-id',cartrecord[i]['id']);;
                carthtmldata.content.querySelector('.cart-item-delete').setAttribute('data-cart-id',cartrecord[i]['id']);
                let clone = document.importNode(carthtmldata.content, true); 
                document.querySelector('.cart-item-data').appendChild(clone);
            } 
        }
    });
}

function get_category(class_name) {
    var get_category = [];
    var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
    
    for (var i = 0; i < checkboxes.length; i++) {
      get_category.push(checkboxes[i].value)
    }
    return get_category;
}       

function productAddButtonClick(clicked) {
    var cartId = clicked;
    
        axios.post('ajax_crud.php', {
            cart_item_add: cartId,
            category: 'AddItem'
        })
        .then(function (response) {            
            alertify.success("Item Added Successfully");
            cartItemData();
            totalDisplay();
        })
        .catch(function (error) {
            console.log(error);
        });
}

function productUpdateButtonClick(clicked) {
    var cartId = clicked;
    
        axios.post('ajax_crud.php', {
            cart_item_add: cartId,
            category: 'UpdateItem'
        })
        .then(function (response) {
            alertify.success("Item Increase Successfully");
            cartItemData();
            totalDisplay();
        })
        .catch(function (error) {
            console.log(error);
        });
}

function productSubtractButtonClick(clicked) {
    var cartId = clicked;
    
        axios.post('ajax_crud.php', {
            cart_item_subtract: cartId,
            category: 'SubtractItem'
        })
        .then(function (response) {
            alertify.success("Item Decrease Successfully");
            cartItemData();
            totalDisplay();
        })
        .catch(function (error) {
            console.log(error);
        });
}

function productDeleteButtonClick(clicked) {
    var cartId = clicked;
    
        axios.post('ajax_crud.php', {
            cart_item_delete: cartId,
            category: 'DeleteItem'
        })
        .then(function (response) {
            alertify.success("Item Delete Successfully");
            cartItemData();
            totalDisplay();
        })
        .catch(function (error) {
            console.log(error);
        });
}

function categoryOnChnage(){
    fetchDataCart();
}

function totalDisplay(){
    var discountTypeDropdown = document.getElementById('check_discount_type');
    var discountType = discountTypeDropdown.options[discountTypeDropdown.selectedIndex].value;
    var discount = document.getElementById('discount').value;
    
    axios({
        url:('amount.php'),
        method:'post',
        data:{discount_amount:discount , discount_type:discountType}
    })
    .then(function(response){
        console.log(response.data);
        var data = response.data;
        document.getElementById('sub_total_name').innerHTML = "Sub-total";
        document.getElementById('sub_total').innerHTML = data['subtotal'];
        if (data['shippingcharge'] == 0){
            document.getElementById('shipping_charge_name').innerHTML = "Shipping Charges";
            document.getElementById('shipping_charge').innerHTML = data['shippingcharge'];
        }
        if (data['discount']) {
            document.getElementById('discount_name').innerHTML = "Discount";
            document.getElementById('discount_amount_cart').innerHTML = data['discount'];
        }
        document.getElementById('total_name').innerHTML = "Total";
        document.getElementById('total').innerHTML = data['total'];
        document.getElementById('tax_name').innerHTML = "Tax";
        document.getElementById('tax').innerHTML = data['tax'];
        document.getElementById('payable_name').innerHTML = "Payable";
        document.getElementById('payable').innerHTML = data['payable'];
    })
}

fetchDataCart();
cartItemData();
totalDisplay();