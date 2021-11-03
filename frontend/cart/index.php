<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Giỏ hàng</title>
    <link rel="stylesheet" href="/../Amazing-PHP/frontend/producer/producer.css">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/frontend/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/frontend/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/frontend/cart/">Giỏ hàng</a>
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
                                <a href="/../Amazing-PHP/frontend/" class="btn_comeback_home">Mua hàng ngay</a>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="row">
                            <div class="col l-8">
                                <div class="cart__product--container">
                                    <div class="cart__product--header">
                                        Giỏ hàng của bạn <i class="fas fa-angle-double-right icon_next"></i>
                                    </div>
                                    <?php $data_cart = $_SESSION['cart']?>
                                    <?php $sum_quantity = 0?>
                                    <?php foreach($data_cart as $val=>$product_item):?>
                                        <div class="cart__product--item <?=$product_item['product_id']?>">
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$product_item['product_name']?>/<?=$product_item['product_img']?>" width="120px">
                                            <div class="cart__product--infor">
                                                <div class="cart__product--name"><?=$product_item['product_name']?></div>
                                                <div class="cart__product--price"><?=number_format($product_item['product_price'],0,',','.')?></div>
                                            </div>
                                            <div>
                                                <div class="cart_product--quantity">
                                                    <input type="button" value="-" id="" class="btn_cart_quantity btn_cart_product--reduce" data-act="0" data-product_id="<?=$product_item['product_id']?>">
                                                    <input type="text" value="<?=$product_item['product_quantity']?>" class="value_cart_product--quantity" readonly>
                                                    <input type="button" value="+" id="" class="btn_cart_quantity btn_cart_product--increase" data-act="1" data-product_id="<?=$product_item['product_id']?>">
                                                </div>
                                            </div>
                                            <div class="cart__product--sumMoney">
                                                <span id="money_abc"><strong>Thành tiền : </strong> <?=number_format($product_item['product_price']*$product_item['product_quantity'],0,',','.')?>đ</span>
                                            </div>
                                            <div>
                                                <div class="cart_product--delete" data-product_id="<?=$product_item['product_id']?>">
                                                    <i class="fas fa-times-circle"></i>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        <?php $sum_quantity += $product_item['product_quantity']?>
                                    <?php endforeach;?> 
                                </div>
                            </div>
                            <div class="col l-4">
                                <div class="cart__product--pay">
                                    <div>
                                        <div class="cart__pay--header">
                                            Tổng thanh toán đơn hàng
                                        </div>
                                        <div class="cart__pay--sumQuantity cart__pay--item">
                                            Số lượng: <span style="font-size: 20px;" id="sum_quantity"><?=$sum_quantity?> sản phẩm</span>
                                        </div>
                                        <div class="cart__pay--sumMoney cart__pay--item">
                                            Thành tiền: <span style="color: green; font-weight: 600; font-size: 20px;" id="sum_money"><?=number_format($sum_money,0,',','.')?>đ</span>
                                        </div>
                                        <div class="cart__pay--buy_now">
                                            Tiến hành thanh toán <i class="fas fa-angle-double-right icon_next"></i>
                                        </div>
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
        <?php include_once __DIR__ . '/../../../Amazing-PHP/frontend/layouts/partials/footer.php'?>
    </div>
</body>
</html>