<?php
    include_once __DIR__ . '/../../connect_db.php';
    $customer_id = $_GET['customer_id'];
    $customer_email = trim($_GET['customer_email']);
    $sql_select_email = <<<EOT
        SELECT * FROM khachhang WHERE EmailKH = '$customer_email' AND MSKH != '$customer_id';
    EOT;
    $query = mysqli_query($conn,$sql_select_email);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($result > 0){
        echo "false";
    }else{
        echo "true";
    }
?>