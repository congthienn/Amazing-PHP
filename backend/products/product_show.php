<?php
    include_once __DIR__ . '/../connect_db.php';
    $product_id = $_GET['product_id'];
    $sql_select_product = <<<EOT
        SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
        ON hh.MaLoaiHang = lhh.MaLoaiHang WHERE MSHH = '$product_id'
    EOT;
    $query = mysqli_query($conn,$sql_select_product);
    $product = mysqli_fetch_array($query,MYSQLI_ASSOC);
    $sql_select_imgs = <<<EOT
        SELECT * FROM hinhhanghoa WHERE MSHH = '$product_id'
    EOT;
    $query_imgs = mysqli_query($conn,$sql_select_imgs);
    $result = '';
    $result .='
    <div class="container">
        <div class="product_information--container"></div>
        <div class="product_information--content">
            <div class="product_information">
                <div class="product_information--title">
                    <div class="name">Sản phẩm '.$product['TenHH'].'</div>
                    <div class="category_name information--item">Loại sản phẩm: '.$product['TenLoaiHang'].'</div>
                    <div class="product_price information--item">Giá bán hiện hành: '.number_format($product['Gia'],0,',','.').'đ</div>
                    <div class="product_quantity information--item">Số lượng còn trong kho: '.$product['SoLuongHang'].' sản phẩm</div>
                </div>
                <div class="product_information--img">
                    <img src="/../Amazing-PHP/assets/uploads/products/'.$product['TenHH'].'/'.$product['HinhDaiDien'].'" width="250px">
                </div>
            </div>
            <div class="product_information--imgs">
                <div class="name">
                    Hình ảnh giới thiệu sản phẩm
                </div>
                <div class="imgs_content">';
                while($row = mysqli_fetch_array($query_imgs,MYSQLI_ASSOC)){
                    $result .= '<img src="/../Amazing-PHP/assets/uploads/products/'.$product['TenHH'].'/'.$row['TenHinh'].'" width="255px">';
                }
    $result .='
                </div>
            </div>

            <div class="product_review">
                <div class="name">
                    Đánh giá giới thiệu sản phẩm
                </div>
                <div>'.$product['GioiThieu'].'</div>
            </div>
        </div>
    </div>
        <script>
            $(".product_information--container").click(function(){
                $(".container").addClass("hide");
                $("body").removeClass("overflow");
            });
        </script>
    ';
    echo json_encode($result);
?>