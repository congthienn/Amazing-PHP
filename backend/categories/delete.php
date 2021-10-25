<?php
    include_once __DIR__ . '/../connect_db.php';
    $maloaihang = trim($_GET['maloaihang']);
    $sql_delete = <<<EOT
        DELETE FROM loaihanghoa WHERE MaLoaiHang = '$maloaihang' OR Parent IN(
            SELECT STT FROM loaihanghoa WHERE MaLoaiHang = '$maloaihang'
        );
    EOT;
    if(mysqli_query($conn,$sql_delete)){
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
?>