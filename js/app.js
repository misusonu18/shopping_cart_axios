// document.querySelector('.button-cart').addEventListener("click",function(){
//     var cartId = this.getAttribute('data-cart-id');
//     axios.post('ajax_crud.php', {
//         cart_item_add: cartId,
//         category: 'AddItem'
//         })
//         .then(function (response) {
//         console.log(response);
//         })
//         .catch(function (error) {
//         console.log(error);
//         });
// });

function fetchDataCart() {
    var category = get_category('category');
    var data = 'data';

    axios.post('fetch_data.php', {
        data: data,
        category: category
      })
      .then(function (response) {
        var data = JSON.stringify(response.data);
        console.log(data);
        document.querySelector('.cart-data').innerHTML = data;
      })

}

function get_category(class_name) {
    var get_category = [];
    var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
    
    for (var i = 0; i < checkboxes.length; i++) {
      get_category.push(checkboxes[i].value)
    }
    console.log(get_category);
    return get_category;
}

fetchDataCart();
// cartItemData();

$(document).on('change','.category',function(){
    fetchDataCart();
});