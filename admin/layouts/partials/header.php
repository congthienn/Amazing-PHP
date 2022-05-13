<link rel="stylesheet" href="/../Amazing-PHP/admin/layouts/css/style_header.css">
<?php
    if(session_id() === ""){
        session_start();
    }
    if(isset($_COOKIE['Staff']) && !empty($_COOKIE['Staff'])){
        $_SESSION['staff'] = $_COOKIE['Staff'];
    }
    if(isset($_COOKIE['Email_staff']) && !empty($_COOKIE['Email_staff'])){
        $_SESSION['email_staff'] = $_COOKIE['Email_staff'];
    }
?>
<div class="header_container">
    <ul class="header_item">
        <li><label class="header_item--child" id="hide_slidebar" for="check_hide_slidebar"><i style="font-size: 20px;" class="fas fa-bars"></i></label></li>
        <input type="checkbox" id="check_hide_slidebar" hidden>
        <li class="header_item--child"><a href="/../Amazing-PHP/admin/">Trang chủ</a></li>
        <li class="header_item--child"><a href="/../Amazing-PHP/admin/products/">Sản phẩm</a></li>
        <li class="header_item--child"><a href="/../Amazing-PHP/admin/order/">Đơn hàng</a></li>
        <!-- <li class="header_item--child"><a href="/../Amazing-PHP/user/">Giao diện user</a></li> -->
    </ul>
    <ul class="header_item">
        <li class="header_item--child"><i class="fas fa-search"></i></li>
        <li class="header_item--child"><i class="far fa-comments"></i></li>
        <li class="header_item--child">
            <div class="slider_logout">
                <i class="fas fa-sign-out-alt nav-icon"></i><span class="text">Đăng xuất</span>
            </div>
        </li>
    </ul>
</div>
<script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function(){
        $("#hide_slidebar").click(function(){
            var check_show_slidebar = $("#check_hide_slidebar").prop("checked");
            if(check_show_slidebar == false){
                $(".text").addClass("hide");
                $(".slidebar_container").animate({"width":"70px"});
                $(".main_slidebar").removeClass('l-2').addClass('l-1-4');
                $(".main_content").removeClass('l-10').addClass('l-11-6');
            }else{
                $(".slidebar_container").animate({"width":"100%"});
                $(".main_slidebar").removeClass('l-1-4').addClass('l-2');
                $(".main_content").removeClass('l-11-6').addClass('l-10');
                $(".text").removeClass("hide");
            }
        });
        $(".slider_logout").click(function() {
            Swal.fire({
                title: 'Bạn muốn đăng xuất?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#333333',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đăng xuất'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "/../../../../Amazing-PHP/admin/layouts/js/logout.php",
                        success: function(response){
                        location.reload();
                        }
                    });
                }
            });
        });
    });
</script>