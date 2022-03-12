$(document).ready(function(){
    $("#province,#district,#ward").select2();
    $("#province").change(function(){
        $("#ward").html('<option value="">Xã / Phường</option>');
        var zipcode = $(this).find("option:selected").data("zipcode");
        var province_id = $(this).val();
        $("#zipcode").val(zipcode);
        $.ajax({
            type: "GET",
            url: "/../../../Amazing-PHP/admin/order/add/select_district.php",
            data:{
                province_id
            },
            dataType:"json",
            success: function (response) {
                $("#district").html(response);
            }
        });
    });
    //Select ward
    $("#district").change(function(){
        var district_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/../../../Amazing-PHP/admin/order/add/select_ward.php",
            data:{
                district_id
            },
            dataType: "json",
            success: function (response) {
                $("#ward").html(response);
            }   
        });
    });
});