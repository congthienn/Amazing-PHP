$(document).ready(function(){
    $("#province,#district,#ward").select2();
    $("#province").change(function(){
        $("#ward").html('<option value="">Xã / Phường *</option>');
        var zipcode = $(this).find("option:selected").data("zipcode");
        var province_id = $(this).val();
        $("#province-error").remove();
        $("#zipcode").val(zipcode);
        $.ajax({
            type: "GET",
            url: "/../../../Amazing-PHP/admin/order/add/select_district.php",
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
        var district_id = $(this).val();
        $("#district-error").remove();
        $.ajax({
            type: "GET",
            url: "/../../../Amazing-PHP/admin/order/add/select_ward.php",
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
        $("#ward-error").remove();
    });
    //Validate
    $("#form_delivery").validate({
        rules:{
            name:{required: true},
            sonha:{required: true},
            province:{required: true},
            district:{required: true},
            ward:{required: true},
            check_2:{required: true},
            check_3:{required: true},
            check_4:{required: true},
            payment:{required:true},
            number:{required: true},
            name_card:{required:true},
            cvv_card:{required: true},
            date_card:{required: true},
        },
        messages:{
            name:{required: "Vui lòng điền tên người nhận hàng"},
            sonha:{required: "Vui lòng nhập số nhà tên đường của bạn"},
            province:{required: "Vui lòng chọn Thành phố / Tỉnh"},
            district:{required: "Vui lòng chọn Quận / Huyện"},
            ward:{required: "Vui lòng chọn Xã / Phường"},
            check_2:{required: "Bạn chưa đủ độ tuổi để đăng kí tài khoản / đặt hàng."},
            check_3:{required: "Vui lòng đồng ý với Chính sách Bảo mật"},
            check_4:{required: "Vui lòng đồng ý với Chính sách Bảo mật và Các Điều khoản và Điều kiện"},
            payment:{required:"Vui lòng chọn hình thức thanh toán cho đơn hàng"},
            number:{required: "Vui lòng nhập mã số của thẻ"},
            name_card:{required:"Vui lòng nhập tên trên thẻ"},
            cvv_card:{required: "Vui lòng nhập mã số bảo mật của thẻ"},
            date_card:{required: "Vui lòng nhập ngày thẻ hết hạn"},
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
    $(".radio_payment").click(function () {
        var val = $(this).val();
        $(".payment").removeClass("checked_radio");
        $(this).parent().addClass("checked_radio");
        if(val==1){
            $("#card").show();
            $("#receive").hide();
        }else{
            $("#card").hide();
            $("#receive").show();
        }
    });
});