<?php
        require_once __DIR__.'/../../../vendor/autoload.php';
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\SMTP;
        include_once __DIR__ . '/../../connect_db.php';
        function inputdata($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripcslashes($data);
            return $data;
        }
        function rand_string(){
            $str='';
            $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@$&#";
            $size = strlen($char);
            for($i=0;$i<10;$i++){
                $str .=$char[rand(0,$size-1)];
            }
            return $str;
        }
        function rand_string_ms(){
            $str='';
            $char = "0123456789";
            $size = strlen($char);
            for($i=0;$i<10;$i++){
                $str .=$char[rand(0,$size-1)];
            }
            return $str;
        }
        if (isset($_POST['submit_form'])) {
            $customer_name = inputdata($_POST['customer_name']);
            $customer_phone = inputdata($_POST['customer_phone']);
            $customer_email_new = inputdata($_POST['customer_email']);
            $customer_email_old = inputdata($_POST['customer_email_old']);
            $customer_id = inputdata($_POST['customer_id']);
            $error = 0;
            //Kiem tra rang buoc phia server
            if(empty($customer_name) || empty($customer_phone) || empty($customer_email_new)){
                $error = 1;
            }
            $sql_select_mail_phone = <<<EOT
                SELECT * FROM khachhang WHERE (EmailKH = '$customer_email_new' OR SoDienThoai = '$customer_phone') AND MSKH != '$customer_id';
            EOT;
            $query = mysqli_query($conn,$sql_select_mail_phone);
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            if($row > 0){
                $error = 1;
            }
            if($error == 0){
                $sql_update_customer = <<<EOT
                  UPDATE khachhang SET HoTenKH = '$customer_name',SoDienThoai = '$customer_phone',
                  WHERE MSKH = '$customer_id';
                EOT;
                mysqli_query($conn,$sql_update_customer);
                if(strcmp($customer_email_new,$customer_email_old)==0){
                    echo "<script>alert('Cập nhật thông tin khách hàng thành công')</script>";
                    echo "<script>location.replace('/../../../../Amazing-PHP/admin/customer')</script>";
                }else{
                    $customer_password = rand_string();
                    $customer_password_encode = sha1(sha1(md5(md5(sha1($customer_password)))));
                    $sql_update_email = <<<EOT
                        UPDATE khachhang SET EmailKH = '$customer_email_new',Password = '$customer_password_encode' WHERE MSKH = '$customer_id'
                    EOT;
                    if(mysqli_query($conn,$sql_update_email)){
                        echo "<script>alert('Cập nhật thông tin khách hàng thành công')</script>";
                        echo "<script>location.replace('/../../../../Amazing-PHP/admin/customer')</script>";
                        $mail = new PHPMailer(true);  
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
                            $mail->addAddress($customer_email_new);              
                            $mail->addReplyTo('congthienn1601@gmail.com');
                            $mail->isHTML(true);                                    
                            $mail->Subject = "Thông báo xác thực tài khoản người dùng trên Amazing";         
                            $body = '
                                <div style="display: flex;justify-content: center; font-size: 17px;position: relative;top: 50%;transform: translateY(-60%);">
                                    <div>
                                        <div style="border: 1px solid black;min-height: 200px;display: inline-block;padding: 20px 20px 40px 20px;border-radius: 5px;">
                                            <div style="margin: 10px 0 20px;"><span style="font-size: 20px;">Amazing xin chào,</span></div>
                                            <div>Xin chào <span style="font-weight: 700;">'.$customer_name.'</span>, bạn vừa cập nhật tài khoản thành công trên Amazing !</div>
                                            <div style="margin: 5px 0;">Đây là mật khẩu đăng nhập tài khoản của bạn:</div>
                                            <div style="font-size: 15px;font-style: italic;">(Bạn vui lòng không cung cấp mật khẩu này cho ai khác)</div>
                                            <div style="display: flex;justify-content: center;align-items: center;">
                                                <div style="border: 1px lightgray solid;display: inline-block;padding: 10px;margin: 30px 0;border-radius: 4px;font-weight: 600;color: blue;">
                                                    '.$customer_password.'
                                                </div>
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
                    }
                }
            }else{
                echo "<script>alert('Cập nhật thông tin khách hàng thất bại, vui lòng kiểm tra lại')</script>";
                echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại!</h2>';
            }
            
        }
?>