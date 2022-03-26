$(document).ready(function(){
    $(".cart_product--delete").click(function(){
        var product_id = $(this).data("product_id");
        var that = $(this);
        $.ajax({
            type: "GET",
            url: "/../Amazing-PHP/user/layouts/partials/delete_product_cart.php",
            data:{
                product_id
            },
            dataType: "json",
            success: function (response) {
                if(Number(response.sum_money) == 0){
                    $("#result_cart_header").html(' <div class="container_cart"><span class="cart_empty">Không có sản phẩm nào trong giỏ hàng</span></div>');
                }else{
                    $('#result_sum_money_cart ,.sum_money').html(response.sum_money);
                    $("."+product_id).remove();
                }
                if(Number(response.quantity_cart) > 0){
                    $("#result_quantity_cart").html('<div class="quantity_cart">'+response.quantity_cart+'</div>');
                    $("#sum_quantity").html(response.quantity_cart+' các sản phẩm');
                }else{
                    $("#result_quantity_cart").html('');
                }
                if(response.buy_now === ''){
                    $("#result_buy_now").html("");
                        var result_cart__product ='<div class="container_cart_empty">';
                        result_cart__product += '<div class="cart_empty">';
                        result_cart__product += '<i class="fas fa-shopping-cart icon_cart_empty"></i>';
                        result_cart__product += '<div class="cart_empty--text">';
                        result_cart__product += 'Không có sản phẩm nào trong giỏ hàng';
                        result_cart__product +=  '</div>';
                        result_cart__product += '<a href="/../Amazing-PHP/user/" class="btn_comeback_home">Mua hàng ngay</a>';
                        result_cart__product +='</div>';
                        result_cart__product += '</div>';
                        $("#result_cart__product").html(result_cart__product);
                }else{
                    that.parent().parent().remove();
                }
            }
        });
    });
});