//Validation form insert
$(document).ready(function () {
    var STT = $("#STT").val();
    var Parent_id = $("#Parent_id").val();
    $("#formInsert").validate({
        rules: {
            madanhmuc: {
                required: true,
                rangelength:[8,8],
                remote:{
                    url:'/../Amazing-PHP/backend/categories/add/validate_id_category.php',
                    type:'get',
                    data:{
                        STT
                    }
                }
            },
            tendanhmuc: {
                required: true,
                remote:{
                    url:'/../Amazing-PHP/backend/categories/add/validate_name_category.php',
                    type:'get',
                    data:{
                        STT
                    }
                }
            },
        },
        messages: {
            madanhmuc: {
                required: "Mã loại hàng hóa không được để trống",
                rangelength:"Mã loại gồm 8 kí tự, vui lòng kiểm tra lại",
                remote:"Mã loại hàng hóa bạn vừa nhập đã tồn tại, vui lòng kiểm tra lại"
            },
            tendanhmuc: {
                required: "Tên loại hàng hóa không được để trống",
                remote:"Tên loại hàng hóa bạn vừa nhập đã tồn tại, vui lòng kiểm tra lại"
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
    $.ajax({
        url:'/../../../../Amazing-PHP/backend/categories/recursive_category.php',
        type:"get",
        data:{
            Parent_id
        },
        success:function(result){
            $("#danhmuccha").html((result));
        }
    });
});
