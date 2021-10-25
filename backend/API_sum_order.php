<?php
    include_once __DIR__ . '/connect_db.php';
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $month_now = date("m",time());
    $year_now = date('Y',time());
    $sql_select_sum_order = <<<EOT
        SELECT COUNT(*) sum_order FROM dathang dh WHERE MONTH(dh.NgayDH) = '$month_now' AND YEAR(dh.NgayDH) = '$year_now';
    EOT;
    $query = mysqli_query($conn,$sql_select_sum_order);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    echo json_encode($result['sum_order'].' đơn hàng');
?>