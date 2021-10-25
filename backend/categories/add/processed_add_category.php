<?php
    include_once __DIR__ . '/../../connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    if(isset($_POST['submit_insert'])){
        $error =0;
        $category_id = inputdata($_POST['madanhmuc']);
        $category_name = inputdata($_POST['tendanhmuc']);
        $category_parent = inputdata($_POST['danhmuccha']);
        if(empty($category_id) || empty($category_name)){
            $error = 1;
        }
        $sql_insert_category = <<<EOT
            INSERT INTO loaihanghoa(MaLoaiHang,TenLoaiHang,Parent) VALUES('$category_id','$category_name','$category_parent'); 
        EOT;
        // Kiem tra rang buon du lieu phia may chu 
        $sql_select_validate = <<<EOT
            SELECT * FROM loaihanghoa WHERE TenLoaiHang = '$category_name' OR MaLoaiHang = '$category_id'
        EOT;
        $query_validate = mysqli_query($conn,$sql_select_validate);
        $row = mysqli_fetch_array($query_validate,MYSQLI_ASSOC);
        if($row > 0){
            $error = 1;
        }
        if($error == 0){
            if(mysqli_query($conn,$sql_insert_category)){
                echo '<script>alert("Thêm mới loại sản phẩm thành công")</script>';
                echo '<script>location.replace("/../../../../Amazing-PHP/backend/categories")</script>';
            }
        }else{
            echo "<script>alert('Thêm mới thông tin thất bại, vui lòng kiểm tra lại')</script>";
            echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại !</h2>';
        }
    }
?>