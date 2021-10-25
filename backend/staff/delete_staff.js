$(document).ready(function(){
    $(".btn_delete").click(function(){
        var that = $(this);
        var staff_id = $(this).data('staff_id');
        Swal.fire({
            title: 'Bạn có muốn xóa thông tin nhân viên?',
            text: "Khi đã xóa bạn không thể phục hồi dữ liệu",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa nhân viên'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "delete_staff.php",
                    data:{
                        staff_id
                    },
                    dataType: "json",
                    success: function (response) {
                        if(Number(response) == 1){
                            Swal.fire({
                                title:"Xóa dữ liệu thành công",
                                icon:"success"
                            });
                            that.parent().parent().parent().remove();
                        }else{
                            Swal.fire({
                                title:"Không thể xóa dữ liệu",
                                text:"Vui lòng kiểm tra lại",
                                icon:"error"
                            });
                        }
                    }
                });
            }
        });
    });
});