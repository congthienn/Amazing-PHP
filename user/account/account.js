$(document).ready(function(){
    $(".edit").click(function(){
        var value = $(this).parent().find(".value").text();
        var name = $(this).data("name");
        var input = '<input class="input-text" type="text" name="'+name+'" id="'+name+'" value="'+value+'">';
        $(this).parent().find(".value").html(input);
        $(this).addClass("hide");
        $(".container-btn").show();
    });
    $(".cancel").click(function() {
        var name = $(this).data("name");
        var phone = $(this).data("phone");
        $(".name").find(".value").html(name+'<input type="hidden" name="name" value="'+name+'">');
        $(".phone").find(".value").html(phone+'<input type="hidden" name="phone" value="'+phone+'">');
        $(".edit").removeClass("hide");
        $(".container-btn").hide();
        $("#old_password, #new_password,#confirm_password").val("");
        $(".container_changer_password").hide();
        
    });
    $(".changer_password").click(function() {
        $(".container-btn").show();
        $(".container_changer_password").show();
    });
}); 