<?php
    include_once __DIR__ . '/connect_db.php';
    $sql_select_month_year = <<<EOT
        SELECT DISTINCT MONTH(NgayDH) month , YEAR(NgayDH) year FROM dathang LIMIT 6
    EOT;
    $query_month_year = mysqli_query($conn,$sql_select_month_year);
    $data_date = [];
    while($result_month_year = mysqli_fetch_array($query_month_year,MYSQLI_ASSOC)){
        $data_date[] = array(
            'month' => $result_month_year['month'],
            'year' => $result_month_year['year'],
        );
    }
    $data_date = array_reverse($data_date);
    $data_doanhthu =[];
    foreach($data_date as $val){
        $month = $val['month'];
        $year = $val['year'];
        $sql_select_doanhthu = <<<EOT
            SELECT SUM((ctdh.SoLuong * ctdh.GiaDatHang)*((100-ctdh.GiamGia)/100)) doanhthu FROM dathang dh JOIN chitietdathang ctdh ON dh.SoDonDH = ctdh.SoDonDH 
            WHERE MONTH(dh.NgayDH) = '$month' AND YEAR(dh.NgayDH) = '$year';
        EOT;
        $query_doanhthu = mysqli_query($conn,$sql_select_doanhthu);
        while($result_doanhthu = mysqli_fetch_array($query_doanhthu,MYSQLI_ASSOC)){
            $data_doanhthu[] = array(
                'time' => $month.'/'.$year,
                'doanhthu' => $result_doanhthu['doanhthu']
            );
        }
    }
    echo json_encode($data_doanhthu);
?>