$(document).ready(function(){
    var customer_id = $("#customer_id").val();
    $('#formInsert').validate({
        rules:{
            customer_name:{
                required:true
            },
            customer_email:{
                required:true,
                email:true,
                remote:{
                    url:"/../../../../Amazing-PHP/backend/customer/add/validate_check_email.php",
                    type:"get",
                    data:{
                        customer_id
                    }
                }
            },
            customer_phone:{
                required:true,
                rangelength:[10,10],
                number:true,
                remote:{
                    url:"/../../../../Amazing-PHP/backend/customer/add/validate_check_phone.php",
                    type:"get",
                    data:{
                        customer_id
                    }
                }
            }
        },
        messages:{
            customer_name:{
                required:"Tên khách hàng không được để trống"
            },
            customer_email:{
                required:"Địa chỉ email không để trống",
                email:"Địa chỉ email không hợp lệ, vui lòng kiểm tra lại",
                remote:"Địa chỉ email bạn vừa nhập đã được đăng kí, vui lòng kiểm tra lại"
            },
            customer_phone:{
                required:"Số điện thoại không được để trống",
                rangelength:"Số điện thoại không hợp lệ, vui lòng kiểm tra lại",
                number:"Số điện thoại không hợp lệ, vui lòng kiểm tra lại",
                remote:"Số điện thoại bạn vừa nhập đã được đăng kí, vui lòng kiểm tra lại"
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