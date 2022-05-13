$(document).ready(function(){
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
                url: "process_login.php",
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
                                location.replace("/../Amazing-PHP/admin")
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
});