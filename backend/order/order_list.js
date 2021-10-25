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
                that.parent().parent().find(".cancel").remove();
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
});