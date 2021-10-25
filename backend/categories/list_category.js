$(document).ready(function(){
    $(".btn-delete").click(function(){
        var maloaihang = $(this).data('id');
        var that = $(this);
        var stt = $(this).data('stt');
        Swal.fire({
            title: 'Bạn có muốn xóa danh mục hàng hóa?',
            text: "Khi đã xóa bạn không thể phục hồi lại dữ liệu!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa danh mục'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:'delete.php',
                    type:'get',
                    data:{
                        maloaihang
                    },
                    success:function(result){
                        if(Number(result)==1){
                            Swal.fire({
                                title:"Xóa dữ liệu thành công",
                                icon:"success"
                            });
                            that.parent().parent().remove();
                            $("."+stt).remove();
                        }else{
                            Swal.fire({
                                title:"Không thể xóa dữ liệu",
                                icon:"error",
                                text:"Vui lòng kiểm tra lại"
                            });
                        }
                    }
                });
            }
        });
    });
});