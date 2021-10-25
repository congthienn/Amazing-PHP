<?php
    include_once __DIR__ . '/../../connect_db.php';
    if(isset($_POST['btn_insertOrder'])){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        function rand_string(){
            $str='';
            $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $size = strlen($char);
            for($i=0;$i<10;$i++){
                $str .=$char[rand(0,$size-1)];
            }
            return $str;
        }
        $mdh = rand_string();
        $mskh = $_POST['customer_information'];
        $ngaydh = date("Y-m-d H:i:s",time());
        $ngaygiao = $_POST['delivery_date'];
        $trangthai_tt = $_POST['pay'];
        if(isset($_POST['text_location']) && !empty($_POST['text_location'])){
            $diachinhanhang = $_POST['text_location'];
        }else{
            $diachinhanhang = $_POST['text_location_company'];
        }
        $hinhthucnhanhang = $_POST['delivery'];
        $trangthaidonhang = 0;
        $product_quantity = $_POST['order_product_quantity'];
        $product_id = $_POST['order_product_id'];
        $product_price = $_POST['order_product_price'];
        $sql_insert_order = <<<EOT
            INSERT INTO dathang(SoDonDH,MSKH,MSNV,NgayDH,NgayGH,ThanhToan,HinhThucNhanHang,DiaChiNhanHang,TrangThaiDH)
            VALUES ('$mdh','$mskh','NV523206','$ngaydh','$ngaygiao','$trangthai_tt','$hinhthucnhanhang','$diachinhanhang','$trangthaidonhang');
        EOT;
        if(mysqli_query($conn,$sql_insert_order)){
            for($i=0;$i<count($product_id);$i++){
                $price = $product_price[$i];
                $quantity = $product_quantity[$i];
                $id = $product_id[$i];
                $sql_check_product = <<<EOT
                    SELECT * FROM chitietdathang WHERE MSHH = '$id' AND SoDonDH = '$mdh';
                EOT;
                $query_check = mysqli_query($conn,$sql_check_product);
                $result_check = mysqli_fetch_array($query_check,MYSQLI_ASSOC);
                if($result_check > 0){
                    $sql_update_product_order = <<<EOT
                        UPDATE chitietdathang SET soluong = soluong + '$quantity' WHERE MSHH = '$id' AND SoDonDH = '$mdh';
                    EOT;
                    mysqli_query($conn,$sql_update_product_order);
                }else{
                    $sql_insert_order_detail = <<<EOT
                        INSERT INTO chitietdathang(SoDonDH,MSHH,SoLuong,GiaDatHang,GiamGia)
                        VALUES ('$mdh','$id','$quantity','$price','0');
                    EOT;
                    mysqli_query($conn,$sql_insert_order_detail);
                }
                $sql_update_quantity = <<<EOT
                    UPDATE hanghoa SET SoLuongHang = SoLuongHang - '$quantity', SoLuongBan = SoLuongBan + '$quantity' WHERE MSHH = '$id';
                EOT;
                mysqli_query($conn,$sql_update_quantity);
            }
            echo "<script>alert('Tạo đơn hàng thành công')</script>";
            echo "<script>location.replace('/../../../../Amazing-PHP/backend/order/')</script>";
        }
    }
?>