<?php
    include_once __DIR__ . "/../connect_db.php";
    $status_order = $_GET["status"];
    $sql_select_count_order = <<<EOT
        SELECT COUNT(*) sum FROM dathang WHERE TrangThaiDH = "$status_order";
    EOT;
    $query_count_order = mysqli_query($conn,$sql_select_count_order);
    $result= mysqli_fetch_array($query_count_order,MYSQLI_ASSOC);
    $count_order_by_status = $result["sum"];
    echo json_encode($count_order_by_status);
?>