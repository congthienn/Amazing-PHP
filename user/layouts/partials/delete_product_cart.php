<?php
    include_once __DIR__ . '/../../../admin/connect_db.php';
    if(session_id()===""){
        session_start();
    }
    $product_id = $_GET['product_id'];
    $data_cart = $_SESSION['cart'];
    $_SESSION['quantity_cart'] = $_SESSION['quantity_cart'] - $data_cart[$product_id]['product_quantity']; 
    unset($data_cart[$product_id]);
    $_SESSION['cart'] = $data_cart;
    $quantity_cart = $_SESSION['quantity_cart'];
    if(empty($_SESSION['cart'])){
        $result_cart_header = 0;
        unset($_SESSION['cart']);
        $result_buy_now = '';
        setcookie("Cart",json_encode($data_cart),time()-60,'/');
        setcookie("Quantity",$_SESSION['quantity_cart'],time()-60,'/');
        unset($_SESSION['quantity_cart']);
    }else{
        $_SESSION['cart'] = $data_cart;
        setcookie("Cart",json_encode($data_cart),time()+(30*24*3600),'/');
        setcookie("Quantity",$_SESSION['quantity_cart'],time()+(30*24*3600),'/');
        $sum_money = 0;
        foreach($data_cart as $val=>$product_item){
            $sum_money += $product_item['product_price'] * $product_item['product_quantity'];
        }
        $result_cart_header = number_format($sum_money,0,',','.').'đ';
        $result_buy_now = 1;
    }
    $data_result = [];
    $data_result['quantity_cart'] = $quantity_cart;
    $data_result['sum_money'] = $result_cart_header;
    $data_result['buy_now'] = $result_buy_now;
    echo json_encode($data_result);
?>