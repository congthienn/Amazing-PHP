$(document).ready(function(){
    //Show product
    $(".btn_show").click(function(){
        $("body").addClass("overflow");
        var product_id = $(this).data('product_id');
        $.ajax({
            url:"product_show.php",
            type:"get",
            dataType:"json",
            data:{
                product_id
            },
            success:function(result){
                $("#product_show").html(result);
            }
        });
    });
    $(".product_information--container").click(function(){
       $(".container").addClass("hide");
    });
    // Xóa sản phẩm
    $(".btn-delete").click(function(){
        var that = $(this);
        var  product_id = $(this).data('product_id');
        var product_name = $(this).data('product_name');
        Swal.fire({
            title: 'Bạn có muốn xóa sản phẩm?',
            text: "Khi đã xóa bạn không thể phục hồi lại dữ liệu!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa sản phẩm'
        }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                   type: "GET",
                   url: "delete_product.php",
                   data:{
                        product_id,product_name
                   },
                   dataType: "json",
                   success: function (result) {
                        if(Number(result)==1){
                            Swal.fire({
                                title:"Xóa sản phẩm thành công",
                                icon:"success"
                            });
                            that.parent().parent().parent().remove();
                        }else{
                            Swal.fire({
                                title:"Không thể xóa dữ liệu vui lòng kiểm tra lại",
                                icon:"error"
                            });
                        }
                   }
               });
            }
        });
    });
});