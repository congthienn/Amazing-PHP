$(document).ready(function(){
    //Show map
    $(".btn_map").click(function(){
        $(".map").addClass("show_map");
        $("html").addClass("over_flow");
    });
    //Hide map
    $(".map , .btn_exit").click(function(){
        $(".map").removeClass("show_map");
        $("html").removeClass("over_flow");
    });
    //Show login
    $(".btn_login_user").click(function(){
        $(".login").addClass("show_login");
        $("html").addClass("over_flow");
    });
    //Hide login
    $(".login_container").click(function(){
        $(".login").removeClass("show_login");
        $("html").removeClass("over_flow");
        $("#email").val("");
        $("#password").val("");
        $("#error_login").children().remove();
    });
    //Hide
    $(".forget_container").click(function(){
        $(".forget_password").removeClass("show_forget_password");
    });
    $(".register_container").click(function(){
        $(".register_user").removeClass("show_register_user");
    });
    //Show password
    $(".show_password").click(function(){
        var check = $("#show_password").prop("checked");
        if(check == false){
            $("#eyes").html('<i class="fas fa-eye"></i>');
            $("#password").attr("type","text");
        }else{
            $("#eyes").html('<i class="fas fa-eye-slash"></i>');
            $("#password").attr("type","password");
        }
    });
    //Xu ly login
    $(".btn_login--user").click(function(){
        var email_user = $("#email").val();
        var password_user = $("#password").val();
        var remember_login = $("#remember_login").prop("checked");
        if(email_user === ""){
            $("#error_login").html('<span><i class="fas fa-exclamation-circle"></i> Vui lòng nhập địa chỉ email</span>');
        }else if(password_user === ""){
            $("#error_login").html('<span><i class="fas fa-exclamation-circle"></i> Vui lòng nhập mật khẩu</span>');
        }else{
            $.ajax({
                type: "GET",
                url: "/../../../../Amazing-PHP/user/layouts/partials/login.php",
                data:{
                    email_user,password_user,remember_login
                },
                dataType:"json",
                success: function (response) {
                    if(response === 'error'){
                        $("#error_login").html('<span><i class="fas fa-exclamation-circle"></i> Tên đăng nhập hoặc mật khẩu không chính xác</span>');
                    }else{
                        Swal.fire({
                            title:"Đăng nhập thành công",
                            icon:"success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });;
                    }
                }
            });
        }
    });
    $(".from--input").click(function(){
        $("#error_login").children().remove();
    });
    //Show forger password
    $(".text_forget_password").click(function(){
        $(".login").removeClass("show_login");
        $("#email").val("");
        $("#password").val("");
        $("#remember_login").prop("checked",false);
        $("#error_login").children().remove();
        $(".forget_password").addClass("show_forget_password");
    });
    //Show login
    $(".text_login_user").click(function(){
        $("#email_forget").val("");
        $(".forget_password").removeClass("show_forget_password");
        $(".login").addClass("show_login");
        $(".register_user").removeClass("show_register_user");
        $("#customer_email,#customer_name,#customer_phone").val("");
        $(".invalid-feedback").remove();
    });
    //Show register 
    $(".text_register_user").click(function(){
        $(".login").removeClass("show_login");
        $("#email").val("");
        $("#password").val("");
        $("#remember_login").prop("checked",false);
        $(".register_user").addClass("show_register_user");
    });
    //Submit forget password
    $("#email_forget").click(function(){
        $("#error_forget").children().remove();
    });
    var check_forget = false;
    $(".btn_forget_passwd").click(function(){
        if(!check_forget){
            var email_user = $("#email_forget").val();
            if(email_user === ""){
                $("#error_forget").html('<span><i class="fas fa-exclamation-circle"></i> Vui lòng nhập địa chỉ email</span>');
            }else{
                check_forget = true;
                $(this).removeClass("btn_forget_passwd").addClass("btn_click");
                $.ajax({
                    type: "GET",
                    url: "/../../../../Amazing-PHP/user/layouts/partials/forget_password.php",
                    data:{
                        email_user
                    },
                    success: function (response) {
                        Swal.fire({
                            title:"Yêu cầu đặt lại thành công",
                            text:"Mật khẩu mới đã được gửi đến email bạn vừa nhập",
                            icon:"success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#email_forget").val("");
                                $(".forget_password").removeClass("show_forget_password");
                                $(".login").addClass("show_login");
                                $(".btn_login").addClass("btn_forget_passwd").removeClass("btn_click");
                            }
                        });
                    }
                });
            }
        }
    });
    //Dang xuat
    $(".btn_logout").click(function(){
        Swal.fire({
            title: 'Bạn muốn đăng xuất?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#333333',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đăng xuất'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "/../../../../Amazing-PHP/user/layouts/partials/logout.php",
                    success: function(response){
                       location.reload();
                    }
                });
            }
        });
    });
    var customer_id = ' ';
    $("#formregisteruser").validate({
        rules: {
            customer_name:{
                required:true
            },
            customer_email:{
                required:true,
                email:true,
                remote:{
                    url:"/../../../../Amazing-PHP/admin/customer/add/validate_check_email.php",
                    type:"GET",
                    data:{
                        customer_id
                    }
                }
            },
            customer_phone:{
                required:true,
                number:true,
                rangelength:[10,10],
                remote:{
                    url:"/../../../../Amazing-PHP/admin/customer/add/validate_check_phone.php",
                    type:"GET",
                    data:{
                        customer_id
                    }
                }
            }
        },
        messages:{
            customer_name:{
                required:"Họ và tên không được để trống"
            },
            customer_email:{
                required:"Địa chỉ email không được để trống",
                email:"Địa chỉ email không hợp lệ",
                remote:"Địa chỉ email bạn vừa nhập đã được đăng kí tài khoản, vui lòng kiểm tra lại"
            },
            customer_phone:{
                required:"Số điện thoại không được để trống",
                number:"Số điện thoại không hợp lệ",
                remote:"Số điện thoại bạn vừa nhập đã được đăng kí tài khỏa, vui lòng kiểm tra lại",
                rangelength:"Số điện thoại không hợp lệ"
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
    //Back top
    $(window).scroll(function(){
        var e = $(window).scrollTop();
        if(e > 150){
            $(".btn_back_top").show();
        }else{
            $(".btn_back_top").hide();
        }
    });
    $(".btn_back_top").click(function(){
        $("html,body").animate({
            scrollTop:0
        });
    });
    //Search product
    $("#search_product").keyup(function(){
        var key = $(this).val();
        $.ajax({
            type: "GET",
            url: "/../Amazing-PHP/user/layouts/partials/search_product.php",
            data:{
                key
            },
            dataType: "json",
            success: function (response) {
                 $('#result_search').html(response);
            }
        });
    });
    $(window).click(function(e){
        $("#result_search").hide();
    });
    $("#search_product").click(function (e) { 
        e.stopPropagation();
        $("#result_search").show();
    });
    //Check login before payment
    $(".button_payment").click(function (e) { 
        e.preventDefault();
        var user = $(this).data("session_user");
        if(user === ""){
            Swal.fire({
                title: 'Vui lòng đăng nhập trước khi xác nhận thanh toán!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#333333',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng nhập'
            }).then((result) => {
                if (result.isConfirmed) {   
                    $(".login").addClass("show_login");
                    $("html").addClass("over_flow");
                    $(".buy_now").hide();
                }
            })
        }else{
            location.replace("/../Amazing-PHP/user/delivery/");
        }
    });
});