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
    if(isset($_COOKIE["Cart"]) && !empty($_COOKIE['Cart'])){
        $_SESSION['cart'] = json_decode($_COOKIE['Cart'],true);
    }
    // unset($_SESSION['cart']);
    // unset( $_SESSION['quantity_cart']);
    // setcookie("Cart",0,time()-60,'/');
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
                <form action="/../Amazing-PHP/frontend/product/" method="GET">
                    <input name="product" type="text" id="search_product" placeholder="Bạn muốn tìm sản phẩm gì...">
                    <button id="btn_search"><span><i class="fas fa-search"></i></span></button>
                    <div id="result_search"></div>
                </form>
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
                    <a href="/../Amazing-PHP/frontend/cart/"><i class="fas fa-shopping-cart icon-header"></i></a>
                    <div id="result_quantity_cart">
                        <?php if(isset($_SESSION['quantity_cart'])):?>
                            <div class="quantity_cart">
                                <?=$_SESSION['quantity_cart'];?>
                            </div>
                        <?php endif;?>
                    </div>
                    <div id="result_cart_header">
                        <div class="container_cart">
                            <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])):?>
                                <?php $data_cart = array_reverse($_SESSION['cart']);?>
                                <?php $sum_money = 0;?>
                                <div class="cart_header--title">
                                    Giỏ hàng của bạn
                                </div>
                                <div class="content_cart">
                                    <?php foreach($data_cart as $val=>$product_item):?>
                                        <?php $sum_money += $product_item['product_price'] * $product_item['product_quantity'];?>
                                            <div class="product_cart--item">
                                                <img src="/../Amazing-PHP/assets/uploads/products/<?=$product_item['product_name']?>/<?=$product_item['product_img']?>" width="90px">
                                                <div class="product_cart--item__infor">
                                                    <div class="cart_product--name">
                                                        <?=$product_item['product_name']?>
                                                    </div>
                                                    <div class="cart_product--price">
                                                        <?=number_format($product_item['product_price'],0,',','.')?>đ
                                                    </div>
                                                    <div class="cart_product--quantity">
                                                        <input type="button" value="-" id="" class="btn_cart_quantity btn_cart_product--reduce" data-act="0" data-product_id="<?=$product_item['product_id']?>">
                                                        <input type="text" value="<?=$product_item['product_quantity']?>" class="value_cart_product--quantity" readonly>
                                                        <input type="button" value="+" id="" class="btn_cart_quantity btn_cart_product--increase" data-act="1" data-product_id="<?=$product_item['product_id']?>">
                                                    </div>
                                                    <div class="cart_product--delete" data-product_id="<?=$product_item['product_id']?>">
                                                        <i class="fas fa-times"></i>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach;?>
                                </div>
                                <div class="sum_money_cart">
                                    <div>
                                        <strong>Tổng tiền </strong>
                                    </div>
                                    <div style="font-size: 20px;" id="result_sum_money_cart"><?=number_format($sum_money,0,',','.')?>đ</div>
                                </div>
                                <div class="button_cart">
                                    <div>
                                        <a href="" class="button_cart--item pay_now">Tiến hành thanh toán</a>
                                    </div>
                                    <div>
                                        <a href="/../Amazing-PHP/frontend/cart/" class="button_cart--item go_cart">Đi đến giỏ hàng</a>
                                    </div>
                                    
                                </div>
                            <?php else:?>
                                <span class="cart_empty">Không có sản phẩm nào trong giỏ hàng</span>
                            <?php endif;?>
                        </div>
                    </div>
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
                <span class="text_register_user">Bạn chưa có tài khoản?</span>
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
                    <span>Hãy cung cấp địa chỉ email của tài khoản và một email đặt lại mật khẩu sẽ được gửi đến địa chỉ email đó</span>
                </div>
                <button class="btn_login btn_forget_passwd">Yêu cầu đặt lại</button>
                <div class="sublite_form_login">
                    <span class="text_login_user">Đã có tài khoản? Đăng nhập</span>
                </div>
            </div>
        </div>       
    </div>
</div>
<div class="register_user">
        <div class="register_container"></div>
        <div class="login_content register_content">
            <div class="login_content--header">
                <a class="logo">
                    <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="80px">
                </a>
                <div class="text_title">
                    Đăng kí tài khoản
                </div>
            </div>
            <div class="login_content--form">
                <form action="/../Amazing-PHP/frontend/layouts/partials/register_user.php" name="formregisteruser" id="formregisteruser" method="POST">
                    <div class="form--item">
                        <label for="customer_name" class="label_login"><i class="fas fa-user"></i> Họ và tên</label>
                        <div class="container--input">
                            <input type="text" id="customer_name" name="customer_name" class="from--input">
                        </div>
                    </div>
                    <div class="form--item">
                        <label for="customer_phone" class="label_login"><i class="fas fa-phone-alt"></i> Số điện thoại</label>
                        <div class="container--input">
                            <input type="tel" id="customer_phone" name="customer_phone" class="from--input">
                        </div>
                    </div>
                    <div class="form--item">
                        <label for="customer_email" class="label_login"><i class="fas fa-envelope"></i> Email</label>
                        <div class="container--input">
                            <input type="email" id="customer_email" name="customer_email" class="from--input">
                        </div>
                    </div>
                    <div class="sublite_form_login">
                        <span>Mật khẩu đăng nhập sẽ được gửi đến email mà bạn đăng kí tài khoản trên Amazing</span>
                    </div>
                    <button class="btn_login btn_register" name=" btn_register">Đăng kí</button>
                    <div class="sublite_form_login">
                        <span class="text_login_user">Đã có tài khoản? Đăng nhập</span>
                    </div>
                </form>
            </div>
        </div>       
    </div>
</div>
<div>
    <button class="btn_back_top"><i class="fas fa-angle-up"></i></button>
</div>
<script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
<script src="/../Amazing-PHP/frontend/layouts/partials/header.js"></script>
<script src="/../Amazing-PHP/assets/vendor/jquery.validate.min.js"></script>
<script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/../Amazing-PHP/frontend/layouts/partials/up_down_quantity.js"></script>
<script src="/../Amazing-PHP/frontend/layouts/partials/delete_product_cart.js"></script>