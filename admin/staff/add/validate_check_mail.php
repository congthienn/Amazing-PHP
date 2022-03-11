<?php
    include_once __DIR__ . '/../../connect_db.php';
    $staff_email = trim($_GET['staff_mail']);
    $staff_id = trim($_GET['staff_id']);
    $sql_select_email = <<<EOT
        SELECT * FROM nhanvien WHERE Email = '$staff_email' AND MSNV != '$staff_id';
    EOT;
    $query = mysqli_query($conn,$sql_select_email);
    $result = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($result > 0){
        echo 'false';
    }else{
        echo 'true';
    }
?>