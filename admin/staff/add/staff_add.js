//Validation form dang ky
$(document).ready(function(){
    var staff_id = $("#staff_id").val();
    $("#formInsert").validate({
        rules:{
            staff_name:{
                required:true
            },
            staff_mail:{
                required:true,
                email:true,
                remote:{
                    url:"/../../../../Amazing-PHP/admin/staff/add/validate_check_mail.php",
                    type:"get",
                    data:{
                        staff_id
                    }
                }
            },
            staff_phone:{
                required:true,
                rangelength:[10,10],
                number:true,
                remote:{
                    url:"/../../../../Amazing-PHP/admin/staff/add/validate_check_phone.php",
                    type:"get",
                    data:{
                        staff_id
                    }
                }
            },
            staff_position:{
                required:true
            },
            staff_location:{
                required:true
            }
        },
        messages:{
            staff_name:{
                required:"Tên nhân viên không được để trống"
            },
            staff_mail:{
                required:"Địa chỉ email không được để trống",
                email:"Email không hợp lệ vui lòng kiểm tra lại",
                remote:"Địa chỉ email banj vừa nhập đã được đăng kí, vui lòng kiểm tra lại"
            },
            staff_phone:{
                required:"Số điện thoại không được để trống",
                rangelength:"Số điện thoại không hợp lệ, vui lòng kiểm tra lại",
                number:"Số điện thoại khong hợp lệ, vui lòng kiểm tra lại",
                remote:"Số điện thoại bạn vừa nhập đã được đăng kí, vui lòng kiểm tra lại"
            },
            staff_position:{
                required:"Vui lòng chọn chức vụ cho nhân viên"
            },
            staff_location:{
                required:"Địa chỉ nhân viên không được để trống"
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