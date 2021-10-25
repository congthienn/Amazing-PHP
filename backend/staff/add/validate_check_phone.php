<?php
    include_once __DIR__ . '/../../connect_db.php';
    $staff_phone=trim($_GET['staff_phone']);
    $staff_id = trim($_GET['staff_id']);
    $sql_select_phone = <<<EOT
        SELECT * FROM nhanvien WHERE SoDienThoai = '$staff_phone' AND MSNV != '$staff_id'
    EOT;
    $query = mysqli_query($conn,$sql_select_phone);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($result > 0){
        echo 'false';
    }else{
        echo 'true';
    }
?>