<?php
    if(session_id() === ""){
        session_start();
    }
    include_once __DIR__ . '/../../admin/connect_db.php';
    require_once __DIR__.'/../../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    date_default_timezone_set("Asia/Ho_Chi_Minh");
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
    if(isset($_POST["btn_order"])){
        $error = false;
        $hotenkh = isset($_POST["name"]) ? inputdata($_POST["name"]) : "";
        $sonha = isset($_POST["sonha"]) ? inputdata($_POST["sonha"]) : "";
        $toanha = isset($_POST["toanha"]) ? inputdata($_POST["toanha"]) : "";
        $province = isset($_POST["provinde"]) ? inputdata($_POST["provinde"]) : "";
        $district = isset($_POST["district"]) ? inputdata($_POST["district"]) : "";
        $ward = isset($_POST["ward"]) ? inputdata($_POST["ward"]) : "";
        $payment = isset($_POST["payment"]) ? inputdata($_POST["payment"]) : "";
        $check_1 = isset($_POST["check_1"]) ? inputdata($_POST["check_1"]) : "";
        $check_2 = isset($_POST["check_2"]) ? inputdata($_POST["check_2"]): "";
        $check_3 = isset($_POST["check_3"]) ? inputdata($_POST["check_3"]) : "";
        $check_4 = isset($_POST["check_4"]) ? inputdata($_POST["check_4"]) : "";
        $card_number = "";
        $card_date = "";
        $card_cvv = "";
        $card_name ="";
        if(empty($hotenkh) || empty($sonha) || empty($check_1) || empty($check_2) || empty($check_3) || empty($check_4) || empty($province) || empty($district) || empty($ward) || empty($payment)){
            $error = true;
            echo $payment.'-';
            echo $province.'-';
            echo $ward.'-';
            echo $district.'-';
            echo $sonha.'-';
            echo $hotenkh.'-';
            echo $check_1.'-';
            echo $check_2.'-';
            echo $check_3.'-';
            echo $check_4.'-';
        }
        if($payment == "1"){
            $card_number = inputdata($_POST["number"]);
            $card_date = inputdata($_POST["date_card"]);
            $card_cvv = inputdata($_POST["cvv_card"]);
            $card_name = inputdata($_POST["name_card"]);
            if(empty($card_name) || empty($card_cvv) || empty($card_date) || empty($card_number)){
                $error = true;
            }
        }
        if($error){
            echo '<h2 style="color:red;">Đã có lỗi xảy ra vui lòng kiểm tra lại</h2>';
        }else{
            $data_cart = $_SESSION['cart'];
            $sum_quantity = 0;
            foreach($data_cart as $val=>$product_item){
                $sum_quantity += $product_item["product_price"] * $product_item["product_quantity"];
            }
            $id_order = rand_string();
            $payment_status = 0;
            $sql_select_location = <<<EOT
                SELECT ward.name wardName,district.name districtName,provinde.name provindeName FROM vn_xa_phuong ward JOIN vn_quan_huyen district ON ward.districtid = district.districtid 
                JOIN vn_tinh provinde ON district.provinceid = provinde.provinceid
                WHERE ward.wardid = "$ward"  
            EOT;
            $email = $_SESSION["email"];
            $sql_selectUser = <<<EOT
                SELECT * FROM khachhang WHERE EmailKH = "$email"
            EOT;
            $query_select_user = mysqli_query($conn,$sql_selectUser);
            $result_user = mysqli_fetch_array($query_select_user,MYSQLI_ASSOC);
            $user_id = $result_user["MSKH"];
            $query_select_location = mysqli_query($conn,$sql_select_location);
            $result_select_location = mysqli_fetch_array($query_select_location,MYSQLI_ASSOC);
            $location = $toanha.$sonha.' - '.$result_select_location['wardName'].' - '.$result_select_location['districtName'].' - '.$result_select_location['provindeName'];
            $ngaydh = date("Y-m-d H:i:s",time());
            $ngaygiao = strtotime ('+10 day',strtotime($ngaydh));
            $ngaygiao = date('Y-m-d', $ngaygiao);
            $trangthaidonhang = 0;
            $error_payment = false;
            if($payment == 1){
                $arrcarddate = explode("/", $card_date);
                $message = '';
                try{
                    $stripe = new \Stripe\StripeClient(
                        'sk_test_51K4M0IK4LLs2jGGUSspuQglEykdgwqGQ1mmQQBRqYtF1mg6ctPKt3KvHAlfgmcooGsU0aRGc7mxWq7ol7IgvtFGc000PoSSyLg'
                    );
                    $paymentMethod = $stripe->paymentMethods->create([
                        'type' => 'card',
                        'card' => [
                          'number' => $card_number,
                          'exp_month' => $arrcarddate[0],
                          'exp_year' => $arrcarddate[1],
                          'cvc' =>  $card_cvv
                        ],
                    ]);
                    $paymentIntents = $stripe->paymentIntents->create([
                        'amount' => $sum_quantity,
                        'currency' => 'vnd',
                        'payment_method' => $paymentMethod['id'],
                        'description' => 'Thanh toán đơn hàng '.$id_order,
                        'confirm'=> true
                    ]);
                    $payment_status = 1;
                }catch(\Stripe\Exception\CardException $e){
                    $error_payment = true;
                    $message = $e->getError()->message;
                }
                if($error_payment){
                    echo '<script>alert("'.$message.'")</script>';
                    echo '<script>history.back();</script>';
                }  
            }
            if(!$error_payment){
                $sql_insert_order = <<<EOT
                INSERT INTO dathang(SoDonDH,MSKH,MSNV,NgayDH,NgayGH,ThanhToan,DiaChiNhanHang,TrangThaiDH)
                VALUES ('$id_order','$user_id','NV000001','$ngaydh','$ngaygiao','$payment_status','$location','$trangthaidonhang');
                EOT;
                mysqli_query($conn,$sql_insert_order);
                foreach($data_cart as $val=>$product_item){
                    $price = $product_item["product_price"];
                    $quantity = $product_item["product_quantity"];
                    $product_id =  $product_item["product_id"];
                    $sql_insert_order_detail = <<<EOT
                        INSERT INTO chitietdathang(SoDonDH,MSHH,SoLuong,GiaDatHang,GiamGia)
                        VALUES ('$id_order','$product_id','$quantity','$price','0');
                    EOT;
                    mysqli_query($conn,$sql_insert_order_detail);
                    $sql_update_quantity = <<<EOT
                        UPDATE hanghoa SET SoLuongHang = SoLuongHang - '$quantity', SoLuongBan = SoLuongBan + '$quantity' WHERE MSHH = '$product_id';
                    EOT;
                    mysqli_query($conn,$sql_update_quantity);
                
                }   
                $success = true;
                $_SESSION["success_order"] = "success";
                unset($_SESSION['cart']);
                unset($_SESSION['quantity_cart']);
                setcookie("Cart","",time()-60,'/');
                setcookie("Quantity","",time()-60,'/');
                $mail = new PHPMailer(true);  
                $message_payment = "Thanh toán sau khi nhận hàng";
                $message_order = "Chưa thanh toán";
                if($payment == 1){
                    $message_payment = "Thanh toán trực tuyến";
                    $message_order ="Đã thanh toán";
                }
                try {
                    $mail->SMTPDebug = 2;       
                    $mail->isSMTP();                           
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true;                             
                    $mail->Username = 'congthienn1601@gmail.com'; 
                    $mail->Password = 'nqhqshsiteocbyul';                 
                    $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS;                             
                    $mail->Port = 465;                                      
                    $mail->CharSet = "UTF-8";
                    $mail->setFrom('Amazing@gmail.com', 'Amazing');
                    $mail->addAddress($email);              
                    $mail->addReplyTo('congthienn1601@gmail.com');
                    $mail->isHTML(true);                                    
                    $mail->Subject = "Thông báo đặt hàng online thành công trên Amazing-PHP";         
                    $body = '
                        <div style="display: flex;justify-content: center; font-size: 17px;position: relative;top: 50%;transform: translateY(-60%);">
                            <div>
                                <div style="border: 1px solid black;min-height: 200px;display: inline-block;padding: 20px 20px 40px 20px;border-radius: 5px;">
                                    <div style="margin: 10px 0 20px;"><span style="font-size: 20px;">Amazing xin chào,</span></div>
                                        <div>Xin chào <span style="font-weight: 700;"> '.$result_user['HoTenKH'].'</span>, bạn vừa được đặt hàng thành công trên Amazing !</div>
                                        <div style="">Mã đơn hàng của bạn là: '.$id_order.'</div>
                                        <div>Giá trị đơn hàng: '.number_format($sum_quantity,0,",",".").' VND </div>
                                        <div>Hình thức thanh toán: '.$message_payment.' </div>
                                        <div>Thanh toán: '.$message_order.' </div>
                                        <div>Ngày giao hàng dự kiến: '.date("d-m-Y",strtotime($ngaygiao)).' </div>
                                    </div>
                                    <div><span style="font-style: italic;">Copyright &copy; <i class="far fa-copyright"></i> Amazing 2020-2021</span></div>
                                </div>
                            </div>
                        </div>
                    ';
                    $mail->Body = $body;
                    $mail->send();
                } catch (Exception $e) {
                    echo 'Lỗi khi gởi mail: ', $mail->ErrorInfo;
                }
                echo "<script>location.replace('/../Amazing-PHP/user/')</script>";
            }  
        }    
    }
?>