<?php
    include_once __DIR__ . '/../../connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    function rand_string(){
        $str='';
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($char);
        for($i=0;$i<10;$i++){
            $str .=$char[rand(0,$size-1)];
        }
        return $str;
    }
    if(isset($_POST['submit_form'])){
        $error = 0;
        $product_id = rand_string();
        $product_name = inputdata($_POST['product_name']);
        $product_price = inputdata($_POST['product_price']);
        $product_quantity = inputdata($_POST['product_quantity']);
        $category_id = inputdata($_POST['category']);
        $product_review = $_POST['product_review'];
        $sql_select_category = <<<EOT
            SELECT * FROM loaihanghoa WHERE STT = '$category_id';
        EOT;
        $query_select_category = mysqli_query($conn,$sql_select_category);
        $result_category = mysqli_fetch_array($query_select_category,MYSQLI_ASSOC);
        $category = $result_category['MaLoaiHang'];
        if(empty($product_name) || empty($product_price) || empty($product_quantity) || empty($product_review)){
            $error = 1;
        }
        $product_img_name = $_FILES['product_img']['name'];
        // Kiểm tra lỗi hình ảnh
        $product_img_type = $_FILES['product_img']['type'];
        $allowTypes = array('jpg', 'png', 'jpeg');
        $type_img= pathinfo($_FILES['product_img']['name'],PATHINFO_EXTENSION);
        if(!in_array($type_img,$allowTypes)){
            $error = 1;
        }
        foreach($_FILES['product_imgs']['name'] as $val){
            $type = pathinfo($val,PATHINFO_EXTENSION);
            if(!in_array($type,$allowTypes)){
                $error = 1;
                break;
            }
        }
        if($error == 0){
            $img_name = [];
            $img_tmp_name = [];
            $sql_insert_product = <<<EOT
                INSERT INTO hanghoa(MSHH,TenHH,GioiThieu,Gia,SoLuongHang,SoLuongBan,MaLoaiHang,HinhDaiDien) 
                VALUES ('$product_id','$product_name','$product_review','$product_price','$product_quantity','0','$category','$product_img_name');
            EOT;
            mysqli_query($conn,$sql_insert_product);
            $upload_dir = __DIR__ . '/../../../assets/uploads/products';
            if(!file_exists($upload_dir.'/'.$product_name)){
                mkdir($upload_dir.'/'.$product_name);
            }
            foreach($_FILES['product_imgs']['name'] as $name){
                $img_name[] = $name;
                $sql_insert_imgs = <<<EOT
                    INSERT INTO hinhhanghoa(TenHinh,MSHH) VALUES ('$name','$product_id');
                EOT;
                mysqli_query($conn,$sql_insert_imgs);
            }
            move_uploaded_file($_FILES['product_img']['tmp_name'],$upload_dir.'/'.$product_name.'/'.$product_img_name);
            foreach($_FILES['product_imgs']['tmp_name'] as $img){
                $img_tmp_name[] = $img;
            }
            for($i=0 ; $i<count($img_name) ; $i++){
                move_uploaded_file($img_tmp_name[$i],$upload_dir.'/'.$product_name.'/'.$img_name[$i]);
            }
            echo "<script>alert('Thêm mới sản phẩm thành công')</script>";
            echo "<script>location.replace('/../../../../Amazing-PHP/admin/products/')</script>";
        }else{
            echo "<script>alert('Thêm mới thông tin thất bại, vui lòng kiểm tra lại')</script>";
            echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại !</h2>';
        }
    }
?>