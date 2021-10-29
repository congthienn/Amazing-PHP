<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/../Amazing-PHP/assets/uploads/tải xuống.png" type="image/x-icon" />
    <?php
        include_once __DIR__ . '/../../../Amazing-PHP/backend/connect_db.php';
        $product_id = $_GET['product'];
        $sql_select_product = <<<EOT
            SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
            ON hh.MaLoaiHang = lhh.MaLoaiHang WHERE MSHH = '$product_id';
        EOT;
        $query_select_product = mysqli_query($conn,$sql_select_product);
        $result_product = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC);
    ?>
    <title>Amazing | <?=$result_product['TenHH']?></title>
    <link rel="stylesheet" href="product.css">
</head>
<?php if($result_product > 0):?>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/frontend/layouts/partials/header.php';?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/frontend/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/frontend/producer/?producer=<?=$result_product['TenLoaiHang']?>"><?=$result_product['TenLoaiHang']?></a> <i class="fas fa-angle-right icon_navbar"></i> <?=$result_product['TenHH']?>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide">
                <div class="row">
                    <div class="col l-5">
                        <?php
                            $sql_select_img = <<<EOT
                                SELECT * FROM hinhhanghoa WHERE MSHH = '$product_id';
                            EOT;
                            $query_select_img = mysqli_query($conn,$sql_select_img);
                            $data_img =[];
                            while($result_img = mysqli_fetch_array($query_select_img,MYSQLI_ASSOC)){
                                $data_img[] = array(
                                    'tenhinh' => $result_img['TenHinh']
                                );
                            }
                        ?>
                        <div class="product_img_container">
                            <div class="big_img">
                                <img id="big_img" src="/../Amazing-PHP/assets/uploads/products/<?=$result_product['TenHH']?>/<?=$data_img[0]['tenhinh']?>" width="100%">
                            </div>
                            <div class="product_img">
                                <?php $i=0;?>
                                <?php foreach($data_img as $val_img):?>
                                    <?php $i++;?>
                                    <?php if($i == 1):?>
                                        <div class="img_product--item check_view">
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$result_product['TenHH']?>/<?=$val_img['tenhinh']?>" width="100%" data-img="<?=$val_img['tenhinh']?>" data-product_name="<?=$result_product['TenHH'];?>">
                                        </div>
                                    <?php else:?>
                                        <div class="img_product--item">
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$result_product['TenHH']?>/<?=$val_img['tenhinh']?>" width="100%" data-img="<?=$val_img['tenhinh']?>" data-product_name="<?=$result_product['TenHH'];?>">
                                        </div>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <div class="col l-4">
                        <div class="container_informaion_product">
                            <div class="product_name product_item">
                                <?=$result_product['TenHH']?>
                            </div>
                            <div class="star product_item">
                                <?php for($i=0;$i<5;$i++):?>
                                    <i class="far fa-star icon_star"></i>
                                <?php endfor;?>
                            </div>
                            <div class="product_id product_item">
                                <div class="sku">SKU: <?=$result_product['MSHH']?></div>
                                <?php if($result_product['SoLuongHang']!=0):?>
                                    <div class="status">Tình trạng: <span class="con">Còn hàng</span></div>
                                <?php else:?>
                                    <div class="status">Tình trạng: <span class="het">Hết hàng</span></div>
                                <?php endif;?>
                            </div>
                            <div class="product_price">
                                <?=number_format($result_product['Gia'],0,',','.')?>đ
                            </div>
                        </div>
                        <div class="container_sale">
                            <span style="font-size: 15px;"><strong><i class="fas fa-box-open"></i> Ưu đãi khi mua hàng</strong></span>
                            <ul>
                                <li>Tặng phiếu mua hàng trị giá 500.000đ cho đơn hàng từ 3.000.000đ</li>
                                <li>Free ship toàn quốc đối với các đơn hàng từ 2.000.000đ trở lên</li>
                                <li>Hoàn trả 100% đối với sản phẩm lỗi</li>
                                <li>Bảo hành chính hãng 1 tháng đối với tất cả các sản phẩm</li>
                            </ul>
                        </div>
                        <div class="product_quantity">
                            <div>
                                <strong>Số lượng mua: </strong>
                            </div>
                            <div style="display: flex; margin-top: 10px;">
                                <input type="button" value="-" readonly class="btn_quantity btn_reduced">
                                <input type="text" value="1" class="value_quantity" readonly id="value_quantity">
                                <input type="button" value="+" readonly class="btn_quantity btn_increase">
                            </div>
                        </div>
                        <div class="buy_product">
                            <div class="buy_now buy_product--item">
                                <div class="buy_title">Mua ngay</div>
                                <div class="buy_sublite">Giao hàng tận COD tận nơi</div>
                            </div>
                            <div class="call_buy buy_product--item">
                                <div class="buy_title">Gọi đặt hàng</div>
                                <div class="buy_sublite">Vui lòng gọi ngay 0911440609</div>
                            </div>
                        </div>
                    </div>
                    <div class="col l-3">
                        <div class="related_products_container">
                            <div class="related_products--header">
                                Có thể bạn thích
                            </div>
                            <?php
                                $sql_select_product_like = <<<EOT
                                    SELECT * FROM hanghoa WHERE MSHH != '$product_id' ORDER BY RAND() LIMIT 5 
                                EOT;
                                $query_product_like = mysqli_query($conn,$sql_select_product_like);
                                $data_product_like = [];
                                while($result_product_like = mysqli_fetch_array($query_product_like,MYSQLI_ASSOC)){
                                    $data_product_like[] = array(
                                        'thh' => $result_product_like['TenHH'],
                                        'mhh' => $result_product_like['MSHH'],
                                        'gia' => $result_product_like['Gia'],
                                        'hinhanh' => $result_product_like['HinhDaiDien']
                                    );
                                }
                            ?>
                            <div class="container_product_like--item">
                                <?php foreach($data_product_like as $val_product_like):?>
                                    <a href="/../Amazing-PHP/frontend/product/?product=<?=$val_product_like['mhh']?>">
                                        <div class="product_like--item">
                                            <div>
                                                <img src="/../Amazing-PHP/assets/uploads/products/<?=$val_product_like['thh']?>/<?=$val_product_like['hinhanh']?>" width="90px">
                                            </div>
                                            <div>
                                                <div class="product_name_like">
                                                    <?=$val_product_like['thh']?>
                                                </div>
                                                <div class="product_price_like">
                                                    <?=number_format($val_product_like['gia'],0,',','.')?>đ
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l-9">
                        <div class="review_product">
                            <?=$result_product['GioiThieu']?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l-12">
                        <div class="container_same_kind_product">
                            <div class="same_kind_product--header">
                                Sản phẩm cùng loại
                            </div>
                            <?php
                                $category_id = $result_product['MaLoaiHang'];
                                $sql_select_same_kind_product = <<<EOT
                                SELECT * FROM hanghoa hh JOIN loaihanghoa lhh 
                                ON hh.MaLoaiHang = lhh.MaLoaiHang WHERE hh.MSHH != '$product_id' AND lhh.MaLoaiHang = '$category_id'
                                EOT;
                                $query_select_sam_kind_product = mysqli_query($conn,$sql_select_same_kind_product);
                                $data_skp = [];
                                while($result_skp = mysqli_fetch_array($query_select_sam_kind_product,MYSQLI_ASSOC)){
                                    $data_skp[] = array(
                                        'thh' => $result_skp['TenHH'],
                                        'mhh' => $result_skp['MSHH'],
                                        'gia' => $result_skp['Gia'],
                                        'hinhanh' => $result_skp['HinhDaiDien']
                                    );
                                }
                            ?>
                            <div class="same_kind_product">
                                <?php foreach($data_skp as $val_skp):?>
                                    <a href="/../Amazing-PHP/frontend/product/?product=<?=$val_skp['mhh']?>">
                                        <div class="same_kind_product--item">
                                            <div class="skp_img">
                                                <img src="/../Amazing-PHP/assets/uploads/products/<?=$val_skp['thh']?>/<?=$val_skp['hinhanh']?>" width="100%">
                                            </div>
                                            <div class="skp_name">
                                                <?=$val_skp['thh'];?>
                                            </div>
                                            <div class="spk_price">
                                                <?=number_format($val_skp['gia'],0,',','.')?>đ
                                            </div>
                                            <div class="star product_item">
                                                <?php for($i=0;$i<5;$i++):?>
                                                    <i class="far fa-star icon_star"></i>
                                                <?php endfor;?>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/frontend/layouts/partials/footer.php';?>
    </div>
</body>
<script src="/../Amazing-PHP/assets/vendor/slick/slick.min.js"></script>
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick-theme.css">
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick.css">
<script src="product.js"></script>
<?php else:?>
    <script>
        location.replace("/../Amazing-PHP/frontend/");
    </script>
<?php endif;?>
</html>