<?php
    include_once __DIR__ . '/../../connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    function rmdir_recurse($path) {
        $path = rtrim($path, '/') . '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
        if($file != '.' and $file != '..' ) {
        $fullpath = $path.$file;
        if (is_dir($fullpath)) rmdir_recurse($fullpath);
        else unlink($fullpath);
        }
        }
        closedir($handle);
        rmdir($path);
    }
    if(isset($_POST['submit_form'])){
        $error = 0;
        $product_id = inputdata($_POST['product_id']);
        $product_name_new = inputdata($_POST['product_name']);
        $product_price = inputdata($_POST['product_price']);
        $product_quantity = inputdata($_POST['product_quantity']);
        $category_id = inputdata($_POST['category']);
        $product_review = $_POST['product_review'];
        $sql_select_product = <<<EOT
            SELECT * FROM loaihanghoa lhh JOIN hanghoa hh ON lhh.MaLoaiHang=hh.MaLoaiHang WHERE hh.MSHH = '$product_id';
        EOT;
        $query_select_product = mysqli_query($conn,$sql_select_product);
        $result_product = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC);
        $sql_select_category = <<<EOT
            SELECT * FROM loaihanghoa WHERE STT = '$category_id';
        EOT;
        $query_category = mysqli_query($conn,$sql_select_category);
        $result_category = mysqli_fetch_array($query_category,MYSQLI_ASSOC);
        $category = $result_category['MaLoaiHang'];
        $product_name_old = $result_product['TenHH'];
        //Kiểm tra lỗi hình ảnh
        if(empty($product_name_new) || empty($product_price) || empty($product_quantity) || empty($product_review)){
            $error = 1;
        }
        $allowTypes = array('jpg', 'png', 'jpeg');
        if(!empty($_FILES['product_img']['name'])){
            $product_img_name = $_FILES['product_img']['name']; 
            $type_img= pathinfo($_FILES['product_img']['name'],PATHINFO_EXTENSION);
            if(!in_array($type_img,$allowTypes)){
                $error = 1;
            }
        }
        if(!empty($_FILES['product_imgs']['name'])){
            foreach($_FILES['product_imgs']['name'] as $val){
                if(!empty($val)){
                    $type = pathinfo($val,PATHINFO_EXTENSION);
                    if(!in_array($type,$allowTypes)){
                        $error = 1;
                        break;
                    }
                } 
            }
        }
        if($error == 0){
            $img_name = [];
            $img_tmp_name = [];
            $sql_update_product = <<<EOT
                UPDATE hanghoa SET TenHH = '$product_name_new', GioiThieu = '$product_review',Gia = '$product_price',
                SoLuongHang = '$product_quantity',MaLoaiHang = '$category' WHERE MSHH = '$product_id'
            EOT;
            mysqli_query($conn,$sql_update_product);
            $upload_dir = __DIR__ . '/../../../assets/uploads/products';
            $dir_old = $upload_dir.'/'.$product_name_old;
            $dir_new = $upload_dir.'/'.$product_name_new;
            rename($dir_old,$dir_new);
            if(!empty($_FILES['product_img']['name'])){
                $product_img_old = $result_product['HinhDaiDien'];
                unlink($dir_new.'/'.$product_img_old);
                $product_img = $_FILES['product_img']['name'];
                $sql_update_img = <<<EOT
                    UPDATE hanghoa SET HinhDaiDien = '$product_img' WHERE MSHH='$product_id';
                EOT;
                mysqli_query($conn,$sql_update_img);
                move_uploaded_file($_FILES['product_img']['tmp_name'],$dir_new.'/'.$product_img);
            }
            $sql_delete_imgs = <<<EOT
                DELETE FROM hinhhanghoa WHERE MSHH = '$product_id'
            EOT;
            if(!empty($_FILES['product_imgs']['name'])){
                foreach($_FILES['product_imgs']['tmp_name'] as $img){
                    if(!empty($img)){
                        $img_tmp_name[] = $img;
                    }
                }
                if(!empty($img_tmp_name)){
                    $sql_select_imgs = <<<EOT
                        SELECT * FROM hinhhanghoa WHERE MSHH = '$product_id'
                    EOT;
                    $query_select_imgs = mysqli_query($conn,$sql_select_imgs);
                    while($row = mysqli_fetch_array($query_select_imgs,MYSQLI_ASSOC)){
                        unlink($dir_new.'/'.$row['TenHinh']);
                    }
                    mysqli_query($conn,$sql_delete_imgs);
                    foreach($_FILES['product_imgs']['name'] as $name){
                        $img_name[] = $name;
                        $sql_insert_imgs = <<<EOT
                            INSERT INTO hinhhanghoa(TenHinh,MSHH) VALUES ('$name','$product_id');
                        EOT;
                        mysqli_query($conn,$sql_insert_imgs);   
                    }
                    for($i=0 ; $i<count($img_name) ; $i++){
                        move_uploaded_file($img_tmp_name[$i],$dir_new.'/'.$img_name[$i]);
                    }
                }
            }
            echo "<script>alert('Cập nhật thông tin sản phẩm thành công')</script>";
            echo "<script>location.replace('/../../../../Amazing-PHP/admin/products/')</script>";
        }else{
            echo "<script>alert('Cập nhật thông tin thất bại, vui lòng kiểm tra lại')</script>";
            echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại !</h2>';
        }
    }
?>