<?php
    include_once __DIR__ . '/../connect_db.php';
    $order_id = $_GET['order_id'];
    $sql_select_product_order = <<<EOT
        SELECT * FROM chitietdathang WHERE SoDonDH = '$order_id';
    EOT;
    $query = mysqli_query($conn,$sql_select_product_order);
    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $quantity = $row['SoLuong'];
        $product_id = $row['MSHH'];
        $sql_update_quantity = <<<EOT
            UPDATE hanghoa SET SoLuongHang = SoLuongHang + '$quantity', SoLuongBan = SoLuongBan - '$quantity' WHERE MSHH = '$product_id';
        EOT;
        mysqli_query($conn,$sql_update_quantity);
    }
    $sql_delete = <<<EOT
        DELETE FROM chitietdathang WHERE SoDonDH = '$order_id';
    EOT;
    mysqli_query($conn,$sql_delete);
    $sql_delete_order = <<<EOT
        DELETE FROM dathang WHERE SoDonDH = '$order_id';
    EOT;
    mysqli_query($conn,$sql_delete_order);
    echo json_encode(1);
?>