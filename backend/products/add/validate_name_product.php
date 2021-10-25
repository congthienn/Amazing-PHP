<?php
    include_once __DIR__ . '/../../connect_db.php';
    $product_name = trim($_GET['product_name']);
    if(isset($_GET['product_id'])){
        $product_id = trim($_GET['product_id']);
    }else{
        $product_id = '';
    }
    $sql_select_product = <<<EOT
        SELECT * FROM hanghoa WHERE TenHH = '$product_name' AND MSHH != '$product_id'
    EOT;
    $query = mysqli_query($conn,$sql_select_product);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($result > 0){
        echo 'false';
    }else{
        echo 'true';
    }
?>