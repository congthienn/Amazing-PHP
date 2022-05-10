<?php
    include_once __DIR__ . '/../connect_db.php';
    $order_id = $_GET['order_id'];
    $val = $_GET['val'];
    if($val == 0){
        $sql_update = <<<EOT
            UPDATE dathang SET TrangThaiDH = 1 WHERE SoDonDH = '$order_id';
        EOT;
        mysqli_query($conn,$sql_update);
        $result = '
            <span class="btn btn-warning btn-sm btn_process" data-order_id="'.$order_id.'" data-val="1">Đang xử lí <i class="fas fa-recycle"></i></span>
            <script src="/../Amazing-PHP/admin/order/order_list.js"></script>        
        ';
    }else if($val == 1){
        $sql_update = <<<EOT
            UPDATE dathang SET TrangThaiDH = 2 WHERE SoDonDH = '$order_id';
        EOT;
        mysqli_query($conn,$sql_update);
        $result = '
            <span class="btn btn-primary btn-sm">Đang giao hàng <i class="fas fa-truck"></i></span>
            <script src="/../Amazing-PHP/admin/order/order_list.js"></script>    
        ';
    }else{
        $sql_update = <<<EOT
            UPDATE dathang SET TrangThaiDH = 3, ThanhToan = 1 WHERE SoDonDH = '$order_id';
        EOT;
        mysqli_query($conn,$sql_update);
        $result = '
            <span class="btn btn-success btn-sm">Đã hoàn thành <i class="fas fa-check"></i></span>
            <script src="/../Amazing-PHP/admin/order/order_list.js"></script>    
        ';
    }
    echo json_encode($result);
?>