
function fetchDataCart() {
    var category = get_category('category');
    var data = 'data';

    axios.post('fetch_data.php', {
        data: data,
        category: category
      })
      .then(function (response) {
        var data = JSON.stringify(response.data);
        var record = response.data;
        var htmldata = document.getElementById('all_products');
        var content = htmldata.content.querySelector('.card');
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
    }).then(function(response){
        var cartrecord = response.data;
        var carthtmldata = document.getElementById('cart_item_products');

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

fetchDataCart();
cartItemData();

$(document).on('change','.category',function(){
    fetchDataCart();
});