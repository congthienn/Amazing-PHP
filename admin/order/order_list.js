$(document).ready(function(){
    $(".btn_detaile_order").click(function(){
        $("#order_item_show").addClass("show");
        var order_id = $(this).data("order_id");
        $.ajax({
            type: "GET",
            url: "show_order.php",
            data:{
                order_id
            },
            dataType: "json",
            success: function (response) {
                $("#order_item_show").html(response);
            }
        });
    });
    $(".order_container").click(function(){
        $("#order_item_show").removeClass("show");
    });
    $(".btn_wait").click(function(){
        var order_id = $(this).data('order_id');
        var val = $(this).data('val');
        var that = $(this);
        Swal.fire({
            title: 'Xác nhận đơn hàng',
            text:'Đơn hàng '+order_id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "confirm_order.php",
                    data: {
                        order_id,val
                    },
                    dataType: "json",
                    success: function (response) {
                        that.parent().html(response);
                    }
                });
            }
        });
    });
    $(".btn_process").click(function(){
        var order_id = $(this).data('order_id');
        var val = $(this).data('val');
        var that = $(this);
       
        Swal.fire({
            title: 'Xác nhận giao hàng',
            text:'Đơn hàng '+order_id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "confirm_order.php",
                    data: {
                        order_id,val
                    },
                    dataType: "json",
                    success: function (response) {
                        that.parent().html(response);   
                    }
                });
                //that.parent().parent().find(".cancel").remove();
            }
        });
    });
    $(".cancel").click(function(){
        var order_id = $(this).data('order_id');
        var that = $(this);
        Swal.fire({
            title: 'Xác nhận hủy đơn hàng',
            text:'Đơn hàng '+order_id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "cancel_order.php",
                        data: {
                            order_id
                        },
                        dataType: "json",
                        success: function (response) {
                            if(Number(response) == 1){
                                Swal.fire({
                                    title:"Hủy đơn hàng thành công",
                                    icon:"success"
                                });
                                that.parent().parent().remove();
                            }
                        }
                    });
                   
                }
            });
    });
    $(".btn_delivery").click(function(){
        var order_id = $(this).data('order_id');
        var val = $(this).data('val');
        var that = $(this);
        Swal.fire({
            title: 'Xác nhận giao hàng thành công',
            text:'Đơn hàng '+order_id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "confirm_order.php",
                    data: {
                        order_id,val
                    },
                    dataType: "json",
                    success: function (response) {
                        that.parent().html(response);
                        $("#"+order_id).html('<span class="pay-item paymented">Đã thanh toán <i class="fas fa-check"></i></span>');
                    }
                });
                //that.parent().parent().find(".cancel").remove();
            }
        });
    });

    function sum_order(status,id){
        $.ajax({
            type: "GET",
            url: "sum_order.php",
            data:{status},
            dataType: "json",
            success: function (response) {
                $("."+id).html(response + " đơn hàng");
            }
        });
    }
    //Wait
    sum_order("0","sum_order_wait");
    $(".refresh_wait").click(function () {
        sum_order("0","sum_order_wait");
    });
    //Process
    sum_order("1","sum_order_process");
    $(".refresh_process").click(function () {
        sum_order("1","sum_order_process");
    });
    //Delivery
    sum_order("2","sum_order_delivery");
    $(".refresh_delivery").click(function () {
        sum_order("2","sum_order_delivery");
    });
    //Success
    sum_order("3","sum_order_success");
    $(".refresh_success").click(function () {
        sum_order("3","sum_order_success");
    });
});