<?php
    include_once __DIR__ . '/../../connect_db.php';
    $customer_id = $_GET['customer_id'];
    $customer_phone = trim($_GET['customer_phone']);
    $sql_select_phone = <<<EOT
        SELECT * FROM khachhang WHERE SoDienThoai = '$customer_phone' AND MSKH != '$customer_id';
    EOT;
    $query_phone = mysqli_query($conn,$sql_select_phone);
    $result = mysqli_fetch_array($query_phone,MYSQLI_ASSOC);
    if($result > 0){
        echo "false";
    }else{
        echo "true";
    }
?>