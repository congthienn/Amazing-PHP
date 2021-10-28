<link rel="stylesheet" href="/../Amazing-PHP/frontend/layouts/css/header.css">
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/responsive.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<?php
    if(session_id() ===""){
        session_start();
    }
    if(isset($_COOKIE['User']) && !empty($_COOKIE['User'])){
        $_SESSION['user'] = $_COOKIE['User'];
    }
    if(isset($_COOKIE['Email']) && !empty($_COOKIE['Email'])){
        $_SESSION['email'] = $_COOKIE['Email'];
    }
    if(isset($_COOKIE['Staff']) && !empty($_COOKIE['Staff'])){
        $_SESSION['staff'] = $_COOKIE['Staff'];
    }
?>
<div class="header">
    <div class="grid wide">
        <div class="navbar_header">
            <div class="navbar_header--item">
                <ul>
                    <li class="child-item first_child">Chào mừng bạn đến với Amazing</li>
                    <li class="child-item store_name">Amazing <a href="https://www.facebook.com/congthien1601" class="fb_link"><i class="fab fa-facebook"></i></a> <a href="https://www.instagram.com/ncthien_1601/?hl=vi"><i class="fab fa-instagram"></i></li></a>
                </ul>
            </div>
            <div class="navbar_header--item">
                <ul>
                    <li class="child-item btn_map"><i class="fas fa-map-marker-alt"></i> Tìm cửa hàng</li>
                    <?php if(isset($_SESSION['user']) && !empty($_SESSION['user'])):?>
                        <li class="child-item last_child child-item__user">
                            <span><i class="fas fa-user-circle"></i> <?=$_SESSION['user']?></span>
                            <div class="container_user_logined">
                                <ul>
                                    <?php if(isset($_SESSION['staff']) && ($_SESSION['staff'])==1):?>
                                        <a href="/../Amazing-PHP/backend/"><li class="container_user_logined--item"><img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="28px">Amazing Admin</li></a>
                                    <?php endif;?>
                                    <li class="container_user_logined--item"><span><i class="fas fa-user-shield"></i> Tài khoản</span></li>
                                    <li class="container_user_logined--item btn_logout"><span><i class="fas fa-sign-out-alt"></i> Đăng xuất</span></li>
                                </ul>
                            </div>
                        </li>
                    <?php else:?>
                        <li class="child-item last_child btn_login_user"><i class="fas fa-sign-in-alt"></i> Đăng nhập</li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
        <div class="header_center">
            <a class="logo" href="/../Amazing-PHP/frontend/">
                <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="55px"> <span class="logo_name">MAZING</span>
            </a>
            <div class="search">
                <input type="text" id="search_product" placeholder="Bạn muốn tìm sản phẩm gì...">
                <button id="btn_search"><span><i class="fas fa-search"></i></span></button>
            </div>
            <div class="hotline">
                <i class="fas fa-phone-square-alt icon-header"></i>
                <div style="padding-left: 10px;position: relative;top: 5px;">
                   <div class="phone">0911440609</div>
                   <span class="hotline_title">Hotline</span>
                </div>
            </div>
            <div class="like">
                <span><i class="fas fa-heart icon-header"></i></span>
            </div>
            <div class="cart">
                <i class="fas fa-shopping-cart icon-header"></i>
            </div>
        </div>
    </div>
</div>
<div class="list_category">
    <div class="grid wide">
        <div class="list_content">
            <ul>
                <li><a href="/../Amazing-PHP/frontend/" class="list_item">Home</a></li>
                <?php
                    include_once __DIR__ . '/../../../backend/connect_db.php';
                    $sql_select_category = <<<EOT
                        SELECT * FROM loaihanghoa
                    EOT;
                    $query_select_category = mysqli_query($conn,$sql_select_category);
                    $data_category =[];
                    while($result_category = mysqli_fetch_array($query_select_category,MYSQLI_ASSOC)){
                        $data_category[] = array(
                            'mlh' => $result_category['MaLoaiHang'],
                            'tlh' => $result_category['TenLoaiHang']
                        );
                    }
                ?>
                <?php foreach($data_category as $val_category):?>
                    <li><a class="list_item" href="/../Amazing-PHP/frontend/producer/?producer=<?=$val_category['tlh']?>"><?=$val_category['tlh']?></a></li>
                <?php endforeach;?>
                <li><a href="" class="list_item">Khuyến mãi</a></li>
                <li><a href="" class="list_item">Liên hệ</a></li>
                <li><a href="" class="list_item">Giới thiệu</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="map">
    <div class="map_content">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8299963655663!2d105.76681311461577!3d10.030883692830002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0f1%3A0x4c90a391d232ccce!2zS2hvYSBDw7RuZyBOZ2jhu4cgVGjDtG5nIFRpbiB2w6AgVHJ1eeG7gW4gVGjDtG5nIChDVFUp!5e0!3m2!1svi!2s!4v1635387113621!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        <div class="btn_exit"><i class="fas fa-times icon_exit"></i></div>
    </div>
</div>
<div class="login">
    <div class="login_container"></div>
    <div class="login_content">
        <div class="login_content--header">
            <a class="logo">
                <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="80px">
            </a>
            <div class="text_title">
                Đăng nhập tài khoản
            </div>
        </div>
        <div class="login_content--form">
            <div class="form--item">
                <label for="email" class="label_login"><i class="fas fa-envelope"></i> Email</label>
                <div class="container--input">
                    <input type="email" id="email" class="from--input">
                </div>
            </div>
            <div class="form--item">
                <label for="password" class="label_login"><i class="fas fa-lock"></i> Mật khẩu</label>
                <div class="container--input">
                    <input type="password" id="password" class="from--input">
                    <div class="show_password"><label for="show_password"><span id="eyes"><i class="fas fa-eye-slash"></i></span></label></div>
                    <input type="checkbox" id="show_password" hidden>
                </div>
            </div>
            <div id="error_login"></div>
            <div class="form--item remember_login">
                <input type="checkbox" id="remember_login" value="1">
                <label for="remember_login">Ghi nhớ đăng nhập</label>
            </div>
            <button class="btn_login btn_login--user">Đăng nhập</button>
            <div class="sublite_form_login">
                <span>Bạn chưa có tài khoản?</span>
                <span class="text_forget_password">Quên mật khẩu ?</span>
            </div>
        </div>
    </div>
</div>
<div class="forget_password">
    <div class="forget_container"></div>
        <div class="login_content">
            <div class="login_content--header">
                <a class="logo">
                    <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="80px">
                </a>
                <div class="text_title">
                    Quên mật khẩu
                </div>
            </div>
            <div class="login_content--form">
                <div class="form--item">
                    <label for="email_forget" class="label_login"><i class="fas fa-envelope"></i> Email</label>
                    <div class="container--input">
                        <input type="email" id="email_forget" class="from--input">
                    </div>
                </div>
                <div id="error_forget"></div>
                <div class="sublite_form_login">
                    <span>Hãy cung cấp địa chỉ email của tài khoản và một email đặt lại mật khẩu sẽ được gửi tới hộp thư đến của bạn</span>
                </div>
                <button class="btn_login btn_forget_passwd">Yêu cầu đặt lại</button>
                <div class="sublite_form_login">
                    <span class="text_login_user">Đã có tài khoản? Đăng nhập</span>
                </div>
            </div>
        </div>       
    </div>
</div>
<script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
<script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/../Amazing-PHP/frontend/layouts/partials/header.js"></script>