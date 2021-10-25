<?php
    include_once __DIR__ . '/connect_db.php';
    $sql_select_month_year = <<<EOT
        SELECT DISTINCT MONTH(NgayDH) month , YEAR(NgayDH) year FROM dathang LIMIT 3
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
    $sql_select_product = <<<EOT
        SELECT MSHH,TenHH,SoLuongHang FROM hanghoa
    EOT;
    $data_json =[];
    $query_select_product = mysqli_query($conn,$sql_select_product);
    while($result_product = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC)){
        $mshh = $result_product['MSHH'];
        $temp = [];
        $i=0;
        foreach($data_date as $val){
            $month = $val['month'];
            $year = $val['year'];
            $sql_select_quantity = <<<EOT
                SELECT SUM(ctdh.SoLuong) sum  FROM chitietdathang ctdh 
                JOIN hanghoa hh ON ctdh.MSHH = hh.MSHH
                JOIN dathang dh ON ctdh.SoDonDH = dh.SoDonDH
                WHERE MONTH(dh.NgayDH) = '$month' AND YEAR(dh.NgayDH) = '$year' AND hh.MSHH = '$mshh'
            EOT;
            $query_sum = mysqli_query($conn,$sql_select_quantity);
            $result_sum = mysqli_fetch_array($query_sum,MYSQLI_ASSOC);

            $sum = ($result_sum['sum'] != '') ? $result_sum['sum'] : 0 ;
            $temp[$i] = $sum;
            $i++;
        }
        $data_json[] = array(
            'product_name' => $result_product['TenHH'],
            'month_1' => $temp['0'],
            'month_2' => $temp['1'],
            'month_3' => $temp['2'],
            'inventory' => $result_product['SoLuongHang']
        );
    }
    echo json_encode($data_json);
?>