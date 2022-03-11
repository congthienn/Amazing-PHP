<?php
    include_once __DIR__ . '/connect_db.php';
    $day_now = date("d-m-Y",time());
    $sql_select_sum_product = <<<EOT
        SELECT COUNT(*) sum FROM hanghoa
    EOT;
    $query_select = mysqli_query($conn,$sql_select_sum_product);
    $result = mysqli_fetch_array($query_select,MYSQLI_ASSOC);
    $sum_product = $result['sum'];
    echo json_encode($sum_product. ' sản phẩm');
?>