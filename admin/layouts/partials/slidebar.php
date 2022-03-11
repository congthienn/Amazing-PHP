<?php
    if(session_id()===""){
        session_start();
    }
?>
<link rel="stylesheet" href="/../Amazing-PHP/admin/layouts/css/style_slidebar.css">
<script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
<div class="slidebar_container">
    <a class="slidebar_header" href="/../Amazing-PHP/admin/">
        <img class="logo" src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="35px">
        <span class="title text">Amazing Admin</span>
    </a>
    <div class="slidebar_content">
        <div class="slidebar_user">
            <i class="fas fa-user-circle"></i> <span class="text"><?=$_SESSION['user']?></span> 
        </div>
        <div class="slidebar_menu">
            <label class="slider_menu--header" data-toggle="collapse" href="#menu" for="check_show_menu">
                <i class="fas fa-folder nav-icon"></i><span class="text">Danh mục quản lí</span><i class="fas fa-caret-up icon_down text"></i>
            </label>
            <input type="checkbox" id="check_show_menu" checked hidden>
            <div id="menu_container">
                <div id="menu"> 
                    <ul>
                        <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/categories/">
                                <i class="nav-icon fas fa-th"></i><span class="link text">Phân loại hàng hóa</span>
                            </a>  
                        </li>
                        <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/products/">
                            <i class="fab fa-product-hunt nav-icon"></i><span class="link text">Quản lí hàng hóa</span>
                            </a>  
                        </li>
                        <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/order/">
                            <i class="fas fa-shopping-cart nav-icon"></i><span class="link text">Quản lí đơn đặt hàng</span>
                            </a>  
                        </li>
                        <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/customer/">
                            <i class="fas fa-address-card nav-icon"></i><span class="link text">Thông tin khách hàng</span>
                            </a>  
                        </li>
                        <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/staff/">
                            <i class="fas fa-users-cog nav-icon"></i><span class="link text">Quản lí nhân viên</span>
                            </a>  
                        </li>
                        <!-- <li class="slidebar_menu--item">
                            <a href="/../Amazing-PHP/admin/staff/">
                            <i class="fas fa-money-check-alt nav-icon"></i><span class="link text">Mã giảm giá</span>
                            </a>  
                        </li>         -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="slider_logout">
        <i class="fas fa-sign-out-alt nav-icon"></i><span class="text">Đăng xuất</span>
    </div> -->
</div>
<script src="/../Amazing-PHP/admin/layouts/js/slidebar.js"></script>