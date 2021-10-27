<link rel="stylesheet" href="/../Amazing-PHP/frontend/layouts/css/header.css">
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/responsive.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
                    <li class="child-item"><i class="fas fa-map-marker-alt"></i> Vị trí cửa hàng</li>
                    <li class="child-item last_child"><i class="fas fa-user"></i> Tài khoản</li>
                </ul>
            </div>
        </div>
        <div class="header_center">
            <div class="logo">
                <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="55px"> <span class="logo_name">MAZING</span>
            </div>
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