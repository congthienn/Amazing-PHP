<?php
    include_once __DIR__ . '/../../../admin/connect_db.php';
    if(session_id()===""){
        session_start();
    }
    $product_id = $_GET['product_id'];
    $act = $_GET['act'];
    $data_cart = $_SESSION['cart'];
    if($act == 1){
        $data_cart[$product_id]['product_quantity']++;
        $_SESSION['quantity_cart']++; 
    }else if($act == 0){
        $data_cart[$product_id]['product_quantity']--;
        if($data_cart[$product_id]['product_quantity']==0){
            $data_cart[$product_id]['product_quantity'] = 1;
        }else{
            $_SESSION['quantity_cart']--;
        }
    }
    $_SESSION['cart'] = $data_cart;
    setcookie("Cart",json_encode($data_cart),time()+(30*24*3600),'/');
    setcookie("Quantity",$_SESSION['quantity_cart'],time()+(30*24*3600),'/');
    $sum_money = 0;
    foreach($data_cart as $val=>$product_item){
        $sum_money += $product_item['product_price'] * $product_item['product_quantity'];
    }
    $data_result = [];
    $data_result['product_quantity'] = $data_cart[$product_id]['product_quantity'];
    $data_result['item_sum'] = number_format(($data_cart[$product_id]['product_quantity']*$data_cart[$product_id]['product_price']),0,',','.').'đ';
    $data_result['sum_money'] = number_format($sum_money,0,',','.').'đ';
    $data_result['quantity_cart_header'] =  $_SESSION['quantity_cart'];
    echo json_encode($data_result);
?>