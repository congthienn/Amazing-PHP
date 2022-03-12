<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Adidas Chính hãng, Converse Chính hãng</title>
    <link rel="stylesheet" href="/../Amazing-PHP/user/index.css">
    <link rel="stylesheet" href="delivery.css">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/user/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/user/delivery/">Xác nhận thông tin giao hàng</a>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide">
                <div class="row">
                    <div class="col l-8">
                        <div class="container--information">
                            <div class="text-tile">Thông tin giao hàng</div>
                            <form action="" method="POST">
                                <div>
                                    <div class="label-title"><label for="name">Họ và tên người nhận *</label></div>
                                    <input id="name" name="name" type="text" class="input-delivery" placeholder="Ví dụ: Nguyễn Công Thiện">
                                </div>
                                <div>
                                    <div class="label-title"><label for="sonha">Số nhà / tên đường *</label></div>
                                    <input id="sonha" name="sonha" type="text" class="input-delivery" placeholder="Ví dụ: 99 Nguyễn Văn Cừ,...">
                                </div>
                                <div>
                                    <div class="label-title"><label for="toanha">Tên tòa nhà / Số tầng</label></div>
                                    <input id="toanha" name="toanha" type="text" class="input-delivery" placeholder="Ví dụ: Tòa nhà X, chung cư 123...">
                                </div>
                                <div style="display: flex;margin-top: 20px;column-gap: 10px;">
                                    <div>
                                        <?php
                                            $sql_select_province = <<<EOT
                                                SELECT * FROM vn_tinh;
                                            EOT;
                                            $query_select_province = mysqli_query($conn,$sql_select_province);
                                            $data_province = [];
                                            while($row = mysqli_fetch_array($query_select_province,MYSQLI_ASSOC)){
                                                $data_province[] = array(
                                                    "province_id" => $row["provinceid"],
                                                    "province_name" => $row["name"],
                                                    "zipcode" => $row["zipcode"]
                                                );
                                            }
                                        ?>
                                        <select name="province" id="province" style="width: 391px;">
                                            <option value="">Chọn Thành phố / Tỉnh *</option>
                                            <?php foreach($data_province as $val):?>
                                                <option value="<?=$val["province_id"]?>" data-zipcode="<?=$val["zipcode"]?>"><?=$val["province_name"]?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div>
                                        <select name="district" class="input-delivery" id="district" style="width: 391px;">
                                            <option value="">Quận / Huyện *</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display:flex;margin-top: 20px;column-gap: 10px;">
                                    <div>
                                        <select name="ward" id="ward" class="input-delivery" style="width: 391px;">
                                            <option value="">Xã / Phường *</option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" id="zipcode" class="input-delivery" readonly placeholder="Mã bưu chính" style="width: 391px;">
                                    </div>
                                </div>
                                <div style="margin-top: 40px;">
                                    <div>
                                        <label class="container">Thông tin thanh toán và giao hàng của tôi là giống nhau.
                                            <input type="checkbox" name="check_1" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="container">Có, tôi trên 15 tuổi *
                                            <input type="checkbox" name="check_2">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                   <div>
                                        <label class="container">Tôi theo đây đồng ý việc chuyển giao, chia sẻ, sử dụng, thu thập và tiết lộ thông tin cá nhân của tôi cho các bên thứ ba được quy định tại Chính sách Bảo mật Amazing-PHP *
                                            <input type="checkbox" name="check_3">
                                            <span class="checkmark"></span>
                                        </label>
                                   </div>
                                   <div>
                                       <label class="container">Tôi đã đọc, hiểu và chấp thuận Chính sách Bảo mật và Các Điều khoản và Điều kiện.*
                                            <input type="checkbox" name="check_4">
                                            <span class="checkmark"></span>
                                        </label>
                                   </div>
                                   <div>
                                        <button class="footer__register--button payment" style="margin: 40px 0;font-size: 15px;" href="/../Amazing-PHP/user/delivery/">Xem lại  &  Thanh toán <i class="fas fa-long-arrow-alt-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col l-4">
                        <div>
                            <div style="border-bottom: 1px solid lightgray;">
                                <div style="font-size:23px;font-weight: 505;text-transform: uppercase;padding: 10px 0;">Chi tiết đơn hàng</div>
                            </div>
                            <div style="margin-top: 10px;">
                                <?php $data_cart = $_SESSION['cart']?>
                                    <?php $sum_quantity = 0?>
                                    <?php foreach($data_cart as $val=>$product_item):?>
                                        <div class="cart__product--item <?=$product_item['product_id']?>">
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$product_item['product_name']?>/<?=$product_item['product_img']?>" width="100px">
                                            <div style="flex: 1;">
                                                <div class="cart__product--detail">
                                                    <div class="cart__product--infor">
                                                        <div class="cart__product--name"><?=$product_item['product_name']?></div>
                                                        <div class="cart__product--price">SL: <?=$product_item["product_quantity"]?> - Giá: <?=number_format($product_item['product_price'],0,',','.')?>đ</div>
                                                    </div>
                                                    <div class="cart__product--sumMoney">
                                                        <span><?=number_format($product_item['product_price']*$product_item['product_quantity'],0,',','.')?>đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php $sum_quantity += $product_item['product_quantity']?>
                                <?php endforeach;?> 
                            </div>
                        </div>     
                        <div style="border-top: 1px solid lightgrey;border-bottom: 1px solid lightgrey;padding: 10px;text-transform: uppercase;">
                            <div>
                                <span style="font-size:23px;font-weight: 505;">Tóm tắt đơn hàng</span>
                            </div>
                            <div style="display: flex;align-items: center;justify-content: space-between;padding-top: 10px;">
                                <div class="cart__pay--sumQuantity">
                                    <span id="sum_quantity"><?=$sum_quantity?> các sản phẩm</span>
                                </div>
                                <div class="cart__pay--sumMoney">
                                    <span class="sum_money"><?=number_format($sum_money,0,',','.')?>đ</span>
                                </div>
                            </div>
                            <div style="display:flex;padding-top: 10px;justify-content: space-between;">
                                <span>Giao hàng</span>
                                <span>Miễn phí</span>
                            </div>
                            <div style="display:flex;padding-top: 10px;justify-content: space-between;font-size: 20px;">
                                <b>Tổng đơn hàng</b>
                                <b class="sum_money"><?=number_format($sum_money,0,',','.')?>đ</b>
                            </div>
                        </div>
                        <div style="padding-top: 15px;">
                            <span style="font-size:15px;text-transform: uppercase;font-weight: 505;">Phương thức thanh toán được chấp nhận</span>
                            <img src="/../Amazing-PHP/assets/uploads/payment.webp" alt="" style="margin-top:10px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/footer.php'?>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/select2/select2.min.js"></script>
    <link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/select2/select2.css">
    <script src="delivery.js"></script>
</body>
</html>
<?php else:?>
    <script>
        location.replace("/../Amazing-PHP/user");
    </script>
<?php endif;?>