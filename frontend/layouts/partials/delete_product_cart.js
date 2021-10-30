$(document).ready(function(){
    $(".cart_product--delete").click(function(){
        var product_id = $(this).data("product_id");
        var that = $(this);
        $.ajax({
            type: "GET",
            url: "/../Amazing-PHP/frontend/layouts/partials/delete_product_cart.php",
            data:{
                product_id
            },
            dataType: "json",
            success: function (response) {
                if(Number(response.sum_money) == 0){
                    $("#result_cart_header").html(' <div class="container_cart"><span class="cart_empty">Không có sản phẩm nào trong giỏ hàng</span></div>');
                }else{
                    $("#result_sum_money_cart").html(response.sum_money);
                    that.parent().parent().remove();
                }
                if(Number(response.quantity_cart) != 0){
                    $("#result_quantity_cart").html('<div class="quantity_cart">'+response.quantity_cart+'</div>');
                }else{
                    $("#result_quantity_cart").html('');
                }
            }
        });
    });
});