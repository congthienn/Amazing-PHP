<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Giỏ hàng</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/user/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/user/cart/">Giỏ hàng</a>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide">
                <div id="result_cart__product">
                    <?php if(!isset($_SESSION['cart']) && empty($_SESSION['cart'])):?>
                        <div class="container_cart_empty">
                            <div class="cart_empty">
                                <i class="fas fa-shopping-cart icon_cart_empty"></i>
                                <div class="cart_empty--text">
                                    Không có sản phẩm nào trong giỏ hàng
                                </div>
                                <a href="/../Amazing-PHP/user/" class="btn_comeback_home">Mua hàng ngay</a>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="row">
                            <div class="col l-8">
                                <div class="cart__product--container">
                                    <div style="margin-bottom: 15px;">
                                        <div class="cart__product--header">
                                            <span style="font-size:30px;text-transform: uppercase;">Giỏ hàng của bạn <i class="fas fa-angle-double-right icon_next"></i></span>
                                        </div>
                                        <span style="font-size:17px;">Các mặt hàng trong giỏ hàng của bạn không được bảo lưu – hãy kiểm tra ngay để đặt hàng.</span>
                                    </div>
                                    <?php $data_cart = $_SESSION['cart']?>
                                    <?php $sum_quantity = 0?>
                                    <?php foreach($data_cart as $val=>$product_item):?>
                                        <div class="cart__product--item <?=$product_item['product_id']?>">
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$product_item['product_name']?>/<?=$product_item['product_img']?>" width="250px">
                                            <div style="flex: 1;">
                                                <div class="cart__product--detail">
                                                    <div class="cart__product--infor">
                                                        <div class="cart__product--name"><?=$product_item['product_name']?></div>
                                                        <div class="cart__product--price"><?=number_format($product_item['product_price'],0,',','.')?>đ</div>
                                                        <div style="margin: 10px 0;font-size: 17px;">
                                                            <span style="font-weight: 500;">Mặt hàng có sẵn mới nhất</span>
                                                        </div>
                                                    </div>
                                                    <div class="cart__product--sumMoney">
                                                        <span id="money_abc"><?=number_format($product_item['product_price']*$product_item['product_quantity'],0,',','.')?>đ</span>
                                                    </div>
                                                    
                                                    <div>
                                                        <div class="cart_product--delete" data-product_id="<?=$product_item['product_id']?>">
                                                            <i class="fas fa-times-circle"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="margin: 0 10px;">
                                                    <div class="cart_product--quantity">
                                                        <input type="button" value="-" id="btn_reduce_<?=$product_item["product_id"]?>" class="btn_cart_quantity btn_cart_product--reduce" data-act="0" data-product_id="<?=$product_item['product_id']?>">
                                                        <input type="text" id="<?=$product_item['product_id']?>" value="<?=$product_item['product_quantity']?>" class="value_cart_product--quantity" readonly>
                                                        <input type="button" value="+" id="btn_increase_<?=$product_item["product_id"]?>" class="btn_cart_quantity btn_cart_product--increase" data-act="1" data-product_id="<?=$product_item['product_id']?>">
                                                    </div>
                                                    <div class="error_quantity_<?=$product_item["product_id"]?>" style="margin-top:10px"></div> 
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <?php $sum_quantity += $product_item['product_quantity']?>
                                    <?php endforeach;?> 
                                </div>
                                <div>
                                </div>
                                <?php $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"])) ? $_SESSION["user"] : "";?>
                                <a class="footer__register--button payment button_payment" data-session_user="<?=$user?>" href="/../Amazing-PHP/user/delivery/">Thanh toán <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                            <div class="col l-4">
                                <div class="cart__product--pay">
                                    <div>
                                        <a class="footer__register--button payment button_payment" data-session_user="<?=$user?>" href="/../Amazing-PHP/user/delivery/">Thanh toán <i class="fas fa-long-arrow-alt-right"></i></a>
                                    </div>
                                    <div style="border: 1px solid lightgrey;padding: 20px;text-transform: uppercase;">
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
                                        <div style="display:flex;padding-top: 10px;justify-content: space-between;font-size: 19px;">
                                            <b>Tổng</b>
                                            <b class="sum_money"><?=number_format($sum_money,0,',','.')?>đ</b>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" id="code" placeholder="Nhập mã khuyến mãi của bạn">
                                    </div>
                                    <div id="submit_code">
                                        <button class="footer__register--button payment">Áp dụng <i class="fas fa-long-arrow-alt-right"></i></button>
                                    </div>
                                    <div style="padding-top: 15px;">
                                        <span style="font-size:15px;text-transform: uppercase;font-weight: 505;">Phương thức thanh toán được chấp nhận</span>
                                        <img src="/../Amazing-PHP/assets/uploads/payment.webp" alt="" style="margin-top:10px">
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/footer.php'?>
    </div>
    <script src="cart.js"></script>
</body>
</html>