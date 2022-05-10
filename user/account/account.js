$(document).ready(function(){
    $(".edit").click(function(){
        var value = $(this).parent().find(".value").text();
        var name = $(this).data("name");
        var input = '<input class="input-text" type="text" name="'+name+'" id="'+name+'" value="'+value+'">';
        $(this).parent().find(".value").html(input);
        $(this).addClass("hide");
        $(".container-btn").show();
    });
    var change_password = false;
    $(".cancel").click(function() {
        var name = $(this).data("name");
        var phone = $(this).data("phone");
        $(".name").find(".value").html(name+'<input type="hidden" name="name" id="name" value="'+name+'">');
        $(".phone").find(".value").html(phone+'<input type="hidden" name="phone" id="phone" value="'+phone+'">');
        $(".edit").removeClass("hide");
        $(".container-btn").hide();
        $("#old_password, #new_password,#confirm_password").val("");
        $(".container_change_password").hide();
        $("#error").html("");
        change_password = false;
    });
    $(".change_password").click(function() {
        $(".container-btn").show();
        $(".container_change_password").show();
        change_password = true;
    });
    $(".save").click(function() {
        var name = $("#name").val();
        var phone = $("#phone").val();
        var old_password = $("#old_password").val();
        var new_password = $("#new_password").val();
        var confirm_password = $("#confirm_password").val();
        $.ajax({
            type:"POST",
            url:"change_user_account.php",
            dataType:"json",
            data:{
                name,phone,old_password,new_password,confirm_password,change_password
            },
            success: function(response){
                if(response.error){
                    $("#error").html(response.message);
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Cập nhật thông tin thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $(".name").find(".value").html(name+'<input type="hidden" name="name" id="name" value="'+name+'">');
                    $(".phone").find(".value").html(phone+'<input type="hidden" name="phone" id="phone" value="'+phone+'">');
                    $(".edit").removeClass("hide");
                    $(".container-btn").hide();
                    $("#old_password, #new_password,#confirm_password").val("");
                    $(".container_change_password").hide();
                    $("#error").html("");
                    change_password = false;
                    $("#user_name").html(name);
                }
            }
        });
    });
}); 