<?php
    include_once __DIR__ . '/../../../../Amazing-PHP/backend/connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $madanhmuc = inputdata($_GET['madanhmuc']);
    $STT = inputdata($_GET['STT']);
    $sql_select_id = <<<EOT
        SELECT * FROM loaihanghoa WHERE MaLoaiHang = '$madanhmuc' AND STT != '$STT';
    EOT;
    $query = mysqli_query($conn,$sql_select_id);
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($row > 1){
        echo "false";
    }else{
        echo "true";
    }
?>