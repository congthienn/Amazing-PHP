$(document).ready(function(){
    $(".btn_cart_quantity").click(function(){
        var product_id = $(this).data("product_id");
        var act = $(this).data("act");
        if(act == 0){
            $(".error_quantity_"+product_id).html('');
            $("#btn_increase_"+product_id).removeClass("disable");
        }
        var that = $(this);
        $.ajax({
            type: "GET",
            url: "/../Amazing-PHP/user/layouts/partials/up_down_quantity.php",
            data:{
                product_id,act
            },
            dataType: "json",
            success: function (response) {
                if(response.error == 0) {
                    that.addClass("disable");
                }
                $(".error_quantity_"+product_id).html(response.error_quantity);
                $('#result_sum_money_cart ,.sum_money').html(response.sum_money);
                that.parent().find(".value_cart_product--quantity").prop("value",response.product_quantity);
                $("."+product_id).find(".value_cart_product--quantity").prop("value",response.product_quantity);
                $("#result_quantity_cart").html('<div class="quantity_cart">'+response.quantity_cart_header+'</div>');
                $("#sum_quantity").html(response.quantity_cart_header+' các sản phẩm');
                that.parent().parent().parent().find("#money_abc").html(response.item_sum);
            }
        });
    });
});