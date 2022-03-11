$(document).ready(function(){
    //slick image
    $('.product_img').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 5
    });
    //view image
    $(".img_product--item").click(function(){
        $(".img_product--item").removeClass('check_view');
        $(this).addClass('check_view');
        var img_name = $(this).children().data('img');
        var product_name = $(this).children().data('product_name');
        var img = '/../Amazing-PHP/assets/uploads/products/'+product_name+'/'+img_name;
        $("#big_img").attr("src",img);
    });
    $(".btn_increase").click(function(){
        var value_quantity = $("#value_quantity").val();
        var  x = Number(value_quantity)+1;
        $("#value_quantity").attr("value",x);
    });
    $(".btn_reduced").click(function(){
        var value_quantity = $("#value_quantity").val();
        if(value_quantity > 1){
            var  x = Number(value_quantity)-1;
            $("#value_quantity").attr("value",x);
        }
    });
    $('.same_kind_product').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
    });
});
$(".btn_buy_now").click(function(){
    $(".buy_now").show()
    var quantity = $("#value_quantity").val();
    var product_id = $(this).data("product_id");
   $.ajax({
       type: "GET",
       url: "add_cart.php",
       data:{
           quantity,product_id
       },
       dataType: "json",
       success: function(response) {
            var result_quantity_cart ='<div class="quantity_cart">'+response.quantity_cart+'</div>';
            $("#result_quantity_cart").html(result_quantity_cart);
            $("#result_cart_header").html(response.cart_header);
            $("#result_buy_now").html(response.buy_now)
       }
   });
});
$(".container_buy_now").click(function(){
    $(".buy_now").hide();
});
$(".content_buy_now").click(function(e){
    e.stopPropagation();
});