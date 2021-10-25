//form content
var demoBaseConfig = {
    selector: 'textarea',
    height: 500,
    plugins: [
        'a11ychecker advcode advlist anchor autolink codesample fullscreen help image imagetools tinydrive',
        ' lists link media noneditable powerpaste preview',
        ' searchreplace table template tinymcespellchecker visualblocks wordcount'
    ],
    toolbar:
        'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image tinydrive',
    spellchecker_dialog: true,
    spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
    tinydrive_demo_files_url: '/docs/demo/tiny-drive-demo/demo_files.json',
    tinydrive_token_provider: function (success, failure) {
        success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
};
tinymce.init(demoBaseConfig);
//upload imgs
$(document).ready(function () {
    var imagesPreview = function (input, placeToInsertImagePreview) {
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('#product_imgs').on('change', function () {
        $(".imgs_preview").children().remove();
        imagesPreview(this, '.imgs_preview');
    });
    $('#product_img').on('change', function () {
        $(".img_container").children().remove();
        imagesPreview(this, '.img_container');
    });
});
//Category
var Parent_id = $("#parent_id").val();
$.ajax({
    url: '/../../../../Amazing-PHP/backend/categories/recursive_category.php',
    type: 'get',
    data:{
        Parent_id
    },
    success: function (result) {
        $("#category").html(result);
    }
});
//validate form product
var product_id = $("#product_id").val();
$("#formInsert").validate({
    rules: {
        product_name: {
            required: true,
            remote: {
                url: "/../../../../Amazing-PHP/backend/products/add/validate_name_product.php",
                type: "get"
            }
        },
        product_price: {
            required: true
        },
        product_quantity: {
            required: true
        },
        category: {
            required: true
        },
        product_review: {
            required: true
        },
        product_img: {
            required: true,
            accept: "image/*"
        },
        "product_imgs[]": {
            required: true,
            accept: "image/*"
        }
    },
    messages: {
        product_name: {
            required: "Tên sản phẩm không được để trống",
            remote: "Tên sản phẩm bạn vừa nhập đã có, vui lòng kiểm tra lại"
        },
        product_price: {
            required: "Giá bán của sản phẩm không được để trống"
        },
        product_quantity: {
            required: "Số lượng sản phẩm không được để trống"
        },
        category: {
            required: "Vui lòng chọn loại danh mục cho sản phẩm"
        },
        product_review: {
            required: "Vui lòng nhập thông tin đánh giá sản phẩm"
        },
        product_img: {
            required: "Ảnh đại diện sản phẩm không được để trống",
            accept: "Định dạng ảnh không hợp lệ, vui lòng kiểm tra lại"
        },
        "product_imgs[]": {
            required: "Vui lòng chọn các hình ảnh chi tiết giới thiệu sản phẩm",
            accept: "Định dạng ảnh không hợp lệ, vui lòng kiểm tra lại"
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