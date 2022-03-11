<?php
    include_once __DIR__ . '/connect_db.php';
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $month_now = date("m",time());
    $year_now = date('Y',time());
    $sql_select_sum_renvenue = <<<EOT
        SELECT SUM((ctdh.SoLuong * ctdh.GiaDatHang)*((100-ctdh.GiamGia)/100)) sum 
        FROM dathang dh JOIN chitietdathang ctdh ON dh.SoDonDH = ctdh.SoDonDH
        WHERE MONTH(dh.NgayDH) = '$month_now' AND YEAR(dh.NgayDH) = '$year_now'; 
    EOT;
    $query = mysqli_query($conn,$sql_select_sum_renvenue);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    echo json_encode(number_format($result['sum'],0,',','.').'đ');
?>