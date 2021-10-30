<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Giỏ hàng</title>
    <link rel="stylesheet" href="/../Amazing-PHP/frontend/producer/producer.css">
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
                    
                <?php endif;?>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/frontend/layouts/partials/footer.php'?>
    </div>
</body>
</html>