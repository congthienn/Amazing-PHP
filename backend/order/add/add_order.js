$(document).ready(function(){
    $("#customer_information").select2();
    // $("#delivery").select2();
    $("#province").select2();
    $("#district").select2();
    $("#ward").select2();
    $("#list_category").select2();
    $("#list_product").select2();
    //Select district
    var province_name = '';
    var district_name = '';
    var ward_name = '';
   
    $("#province").change(function(){
        $("#ward").html('<option value="">Xã / Phường</option>');
        $("#stress").val('');
        var province_id = $(this).val();
        var text_location ='';
        province_name = $(this).find("option:selected").text();
        
        text_location += '<textarea type="text" class="form-control" id="text_location" name="text_location" rows="1" readonly>'+province_name+'</textarea>';
        $(".text_location").html(text_location);
        $.ajax({
            type: "GET",
            url: "select_district.php",
            data:{
                province_id
            },
            dataType:"json",
            success: function (response) {
                $("#district").html(response);
            }
        });
    });
    //Select ward
    $("#district").change(function(){
        var text_location ='';
        var district_id = $(this).val();
        $("#stress").val('');
        district_name = $(this).find("option:selected").text();
        text_location += '<textarea type="text" class="form-control" id="text_location" name="text_location" rows="2" readonly>'+district_name+' - '+province_name+'</textarea>';
        $(".text_location").html(text_location);
        $.ajax({
            type: "GET",
            url: "select_ward.php",
            data:{
                district_id
            },
            dataType: "json",
            success: function (response) {
                $("#ward").html(response);
            }   
        });
    });
    $("#ward").change(function(){
        var text_location ='';
        $("#stress").val('');
        ward_name = $(this).find("option:selected").text();
        text_location += '<textarea type="text" class="form-control" id="text_location" name="text_location" rows="2" readonly>'+ward_name+' - '+district_name+' - '+province_name+'</textarea>';
        $(".text_location").html(text_location);
    });
    $("#stress").keyup(function () { 
        var text_location ='';
        var val_stress = $(this).val();
        text_location += '<textarea type="text" class="form-control" id="text_location" name="text_location" rows="2" readonly>'+val_stress+' - '+ward_name+' - '+district_name+' - '+province_name+'</textarea>';
        $(".text_location").html(text_location);
    });
    $("#delivery").change(function(){
        var delivery_id = $(this).val();
        if(delivery_id == 2){
            $(".location_content").addClass("show");
            $(".company_location").removeClass("show");
        }else if(delivery_id == 1){
            $(".location_content").removeClass("show");
            $(".company_location").addClass("show");
        }else if(delivery_id == ''){
            $(".location_content").removeClass("show");
            $(".company_location").removeClass("show");
        }
    });
    //Select category
    $.ajax({
        type: "GET",
        url: "/../../../../Amazing-PHP/backend/categories/recursive_category.php",
        success: function (response) {
            $("#list_category").html(response);
        }
    });
    //Select product in category
    $("#list_category").change(function(){
        var category_id = $(this).val();
        $(".product_price").html(' <input type="text" value="" class="form-control" placeholder="Giá bán" readonly>')
        $.ajax({
            type: "GET",
            url: "select_product.php",
            data: {
                category_id
            },
            dataType: "json",
            success: function (response) {
                $("#list_product").html(response);
            }
        });
    });
    //Select price product
    $("#list_product").change(function(){
        var test = $(this).find("option:selected").data("product_price");
        $(".product_price").html(' <input type="text" value="'+test+'" id="product_price" class="form-control" placeholder="Giá bán" readonly>')
        $('#error_product_name').children().remove();
    });
    $("#product_quantity").click(function(){
        $('#error_product_quantity').children().remove();
    });
    var i = 0;
    var sum_quantity =0;
    var sum_price = 0;
    function check_quantity(product_quantity,product_id){
        var error_ajax = 0;
        $.ajax({
                type: "GET",
                url: "check_product_quantity.php",
                async:false,
                global: false,
                data:{
                    product_quantity,product_id
                },
                dataType: "json",
                success: function (response) {
                    if(response !== 'true'){
                        error_ajax = 1;
                        $("#error_product_quantity").html(response);
                    }
                }
            });
        return error_ajax;
    }
    $("#result_product_order").on("click",".btn_delete",function(){
        var review_order = '';
        var quantity_delete =  $(this).parent().parent().find(".quantity_order").data('quantity');
        var price_delete = $(this).parent().parent().find(".price_order").text();
        sum_price = sum_price - Number(quantity_delete)*Number(price_delete);
        sum_quantity = sum_quantity - Number(quantity_delete);
        review_order += '<td colspan="2"><strong>Tổng cộng</strong></td>';
        review_order += '<td class="text-center text-danger"><strong>'+sum_quantity+' sản phẩm</strong></td>';
        review_order += '<td></td>';
        review_order += '<td class="text-center text-danger"><strong>'+sum_price+'</strong></td>';
        $(this).parent().parent().remove();
        if(sum_price === 0){
            $("#money_sum_order").attr("value",'');
        }else{
            $("#money_sum_order").attr("value",sum_price);
        }
        $("#review_order").html(review_order);
    });
    $('#btn_insert_product').click(function(){
        var product_id = $("#list_product").find("option:selected").val();
        var product_name = $("#list_product").find("option:selected").text();
        var product_price = $("#list_product").find("option:selected").data("product_price");
        var product_quantity = $("#product_quantity").val();
        var product_img = $("#list_product").find("option:selected").data("product_img");
        var error = 0; 
        var error_ajax = 0;
        if(product_id == ''){
            $("#error_product_name").html('<span><i class="fas fa-exclamation-circle"></i> Vui lòng chọn sản phẩm</span>')
            error = 1;
        }else if(product_quantity == ''){
            $("#error_product_quantity").html('<span><i class="fas fa-exclamation-circle"></i> Nhập số lượng mua</span>')
            error = 1;
        }else{
            error = check_quantity(product_quantity,product_id);
        }
        if(error == 0){ 
            i++;
            var product_item ='';
            var review_order = '';
            product_item +='<tr>';
            product_item +='<td class="text-center"><strong>'+i+'</strong></td>';
            product_item +='<td>';
            product_item +='<img src="/../Amazing-PHP/assets/uploads/products/'+product_name+'/'+product_img+'" width="50px">';
            product_item +='<strong style="margin-left: 5px;">'+product_name+'</strong>';
            product_item +='<input type="hidden" name="order_product_id[]" value="'+product_id+'">';
            product_item +='</td>';
            product_item +='<td class="text-center quantity_order" data-quantity ="'+product_quantity+'">';
            product_item += product_quantity+' sản phẩm';
            product_item +='<input type="hidden" name="order_product_quantity[]" value="'+product_quantity+'">';
            product_item +='</td>';
            product_item +='<td class="text-center price_order">';
            product_item +=product_price;
            product_item +='<input type="hidden" name="order_product_price[]" value="'+product_price+'">';
            product_item +='</td>';
            product_item +='<td class="text-center sum_price ">'+product_price*product_quantity+'</td>';
            product_item +='<td class="text-center">';
            product_item +='<span class="btn btn-danger btn-sm btn_delete">Xóa</span>';
            product_item +='</td>';
            product_item +='</tr>';
            sum_quantity = Number(sum_quantity) + Number(product_quantity);
            sum_price = Number(sum_price) + Number(product_price)*Number(product_quantity);
            review_order += '<td colspan="2"><strong>Tổng cộng</strong></td>';
            review_order += '<td class="text-center text-danger"><strong>'+sum_quantity+' sản phẩm</strong></td>';
            review_order += '<td></td>';
            review_order += '<td class="text-center text-danger"><strong>'+sum_price+'</strong></td>';
            $("#review_order").html(review_order);
            $("#result_product_order").append(product_item);
            $("#list_category").prop("value",'');
            $("#list_product").prop("value",'');
            $("#product_price").val('');
            //Thu vien select2
            $("#select2-list_category-container").text('Chọn danh mục loại hàng hóa');
            $("#select2-list_product-container").text('Chọn sản phẩm');
            $("#product_quantity").prop("value",'');
            $("#money_sum_order").attr("value",sum_price);
        }
    });
    $("#formInsertOrder").validate({
        rules:{
            customer_information:{
                required:true
            },
            delivery_date:{
                required:true,
                remote:{
                    url:"check_day.php",
                    type:"get",
                }
            },
            delivery:{
                required:true
            },
            pay:{
                required:true
            },
            text_location:{
                required:true
            },
            money_sum_order:{
                required:true
            }
        },
        messages:{
            customer_information:{
                required:"Thông tin khách hàng không được để trống"
            },
            delivery_date:{
                required:"Chọn khoảng thời gian giao hàng",
                remote:"Ngày giao hàng không hợp lệ"
            },
            delivery:{
                required:"Chọn hình thức nhận hàng"
            },
            pay:{
                required:"Xác nhận trạng thái thanh toán đơn hàng"
            },
            text_location:{
                required:"Vui lòng nhập địa chỉ giao hàng / nhận hàng"
            },
            money_sum_order:{
                required:"Vui lòng chọn sản phẩm cần mua trước khi tạo đơn hàng"
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        success: function (label, element) { },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        }
    });
});