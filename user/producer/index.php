<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Adidas Chính hãng, Converse Chính hãng</title>
    <link rel="stylesheet" href="/../Amazing-PHP/user/index.css">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="producer.css">
    <?php $category = $_GET['producer'];?>
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/user/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/user/producer/?producer=<?=$category?>"><?=$category?></a>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide">
                <div class="product_list">
                            <?php
                                include_once __DIR__ . '/../../../Amazing-PHP/admin/connect_db.php';
                                $category_id = $val_category['mlh'];
                                $sql_select_product = <<<EOT
                                    SELECT * FROM hanghoa hh JOIN loaihanghoa lhh ON hh.MaLoaiHang = lhh.MaLoaiHang
                                    WHERE lhh.TenLoaiHang = '$category';
                                EOT;
                                $data_product = [];
                                $query_product = mysqli_query($conn,$sql_select_product);
                                while($result_product = mysqli_fetch_array($query_product,MYSQLI_ASSOC)){
                                    $data_product[] = array(
                                        'thh' => $result_product['TenHH'],
                                        'mhh' => $result_product['MSHH'],
                                        'gia' => $result_product['Gia'],
                                        'hinhanh' => $result_product['HinhDaiDien']
                                    );
                                }
                            ?>
                            <div class="product_content">
                                <div class="row no-gutters">
                                    <?php foreach($data_product as $val_product):?>
                                        <div class="col l-3">
                                            <a href="/../Amazing-PHP/user/product/?product=<?=$val_product['mhh']?>" class="link_product">
                                            <div class="product_information">
                                                <div class="like_product"><i class="far fa-heart"></i></div>
                                                <div class="product_img">
                                                    <img src="/../Amazing-PHP/assets/uploads/products/<?=$val_product['thh']?>/<?=$val_product['hinhanh']?>" width="100%">
                                                </div>
                                                <div class="product_name">
                                                    <?=$val_product['thh']?>
                                                </div>
                                                <div class="star">
                                                    <?php for($i=0;$i<5;$i++):?>
                                                    <i class="far fa-star icon_star"></i>
                                                    <?php endfor;?>
                                                </div>
                                                <div style="display: flex;justify-content: space-between;">
                                                    <div>
                                                        <div class="product_price">
                                                            <?=number_format($val_product['gia'],0,',','.')?>đ
                                                        </div>
                                                        <div class="product_id">
                                                            SKU: <?=$val_product['mhh']?>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="buy_product">
                                                        <button class="btn_buy_product">Mua ngay</button>
                                                    </div> -->
                                                </div>
                                            
                                            </div>
                                            </a>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/footer.php'?>
    </div>
</body>
<script src="/../Amazing-PHP/assets/vendor/slick/slick.min.js"></script>
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick-theme.css">
<link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/slick/slick.css">
<script>
    $(document).ready(function(){
        $('.img_ads').slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear'
        });
    });  
</script>
</html>