<?php
    include_once __DIR__ . '/../../connect_db.php';
    $product_quantity = $_GET['product_quantity'];
    $product_id = $_GET['product_id'];
    $sql_select_quantity = <<<EOT
        SELECT * FROM hanghoa WHERE MSHH = '$product_id'
    EOT;
    $query_select = mysqli_query($conn,$sql_select_quantity);
    $result_select = mysqli_fetch_array($query_select,MYSQLI_ASSOC);
    $quantity = $result_select['SoLuongHang'];
    if($quantity > $product_quantity){
        echo json_encode("true");
    }else{
        $result = '<span><i class="fas fa-exclamation-circle"></i> Chỉ còn '.$quantity.' sản phẩm</span>';
        echo json_encode($result);
    }
?>