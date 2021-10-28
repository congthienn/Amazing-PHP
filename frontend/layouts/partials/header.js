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
                url: "/../../../../Amazing-PHP/frontend/layouts/partials/login.php",
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
                            text:"Xin chào "+response,
                            icon:"success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(".login").removeClass("show_login");
                                $("#email").val("");
                                $("#password").val("");
                                $("#error_login").children().remove();
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
        $("#error_login").children().remove();
        $(".forget_password").addClass("show_forget_password");
    });
    //Show login
    $(".text_login_user").click(function(){
        $("#email_forget").val("");
        $(".forget_password").removeClass("show_forget_password");
        $(".login").addClass("show_login");
    });
    //Submit forget password
    $("#email_forget").click(function(){
        $("#error_forget").children().remove();
    });
    $(".btn_forget_passwd").click(function(){
        var email_user = $("#email_forget").val();
        if(email_user === ""){
            $("#error_forget").html('<span><i class="fas fa-exclamation-circle"></i> Vui lòng nhập địa chỉ email</span>');
        }else{
            $(".btn_login").removeClass("btn_forget_passwd").addClass("btn_click");
            $.ajax({
                type: "GET",
                url: "/../../../../Amazing-PHP/frontend/layouts/partials/forget_password.php",
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
    });
});