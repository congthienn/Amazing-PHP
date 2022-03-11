<?php
    include_once __DIR__ . '/connect_db.php';
    $sql_select_month_year = <<<EOT
        SELECT DISTINCT MONTH(NgayDH) month , YEAR(NgayDH) year FROM dathang ORDER BY month DESC LIMIT 6
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
    $data_sum =[];
    foreach($data_date as $val){
        $month = $val['month'];
        $year = $val['year'];
        $sql_select_sum_order = <<<EOT
            SELECT COUNT(*) sum FROM dathang dh WHERE MONTH(dh.NgayDH) = '$month' AND YEAR(dh.NgayDH) = '$year'; 
        EOT;
        $query_sum_order = mysqli_query($conn,$sql_select_sum_order);
        while($result_sum_order = mysqli_fetch_array($query_sum_order,MYSQLI_ASSOC)){
            $data_sum[] = array(
                'time' => $month.'/'.$year,
                'sum' => $result_sum_order['sum']
            );
        }
    }
    echo json_encode($data_sum);
?>