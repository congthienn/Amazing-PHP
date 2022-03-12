$(document).ready(function(){
    $("#code").keyup(function(){
        var code = $(this).val();
        if(code.length > 0) {
            $("#submit_code").show();
        }else{
            $("#submit_code").hide();
        }
    });
});