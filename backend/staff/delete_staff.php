<?php
    include_once __DIR__ . '/../connect_db.php';
    $staff_id = $_GET['staff_id'];
    $sql_delete_staff =  <<<EOT
        DELETE FROM nhanvien WHERE MSNV = '$staff_id';
    EOT;
    if(mysqli_query($conn,$sql_delete_staff)){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>