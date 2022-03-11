<?php
    include_once __DIR__ . '/../../../../Amazing-PHP/admin/connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $category_name = inputdata($_GET['tendanhmuc']);
    $STT = inputdata($_GET['STT']);
    $sql_select_name = <<<EOT
        SELECT * FROM loaihanghoa WHERE TenLoaiHang = '$category_name' AND STT != '$STT';
    EOT;
    $query = mysqli_query($conn,$sql_select_name);
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    if($row > 1){
        echo 'false';
    }else{
        echo 'true';
    }
?>