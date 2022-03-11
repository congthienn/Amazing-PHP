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
        $char = "0123456789";
        $size = strlen($char);
        for($i=0;$i<6;$i++){
            $str .=$char[rand(0,$size-1)];
        }
        return $str;
    }
    function rand_string_password(){
        $str='';
        $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@$&#";
        $size = strlen($char);
        for($i=0;$i<10;$i++){
            $str .=$char[rand(0,$size-1)];
        }
        return $str;
    }
    if(isset($_POST['submit_form'])){
        $error =0;
        $staff_id = "NV".rand_string();
        $staff_name = inputdata($_POST['staff_name']);
        $staff_email = inputdata($_POST['staff_mail']);
        $staff_phone = inputdata($_POST['staff_phone']);
        $staff_location = inputdata($_POST['staff_location']);
        $staff_position = inputdata($_POST['staff_position']);
        $sql_select_position = <<<EOT
            SELECT * FROM chucvu WHERE cv_id = '$staff_position';
        EOT;
        $query_position = mysqli_query($conn,$sql_select_position);
        $result_position = mysqli_fetch_array($query_position,MYSQLI_ASSOC);
        $staff_password = rand_string_password();
        $staff_password_encode = sha1(sha1(md5(md5(sha1($staff_password)))));
        //Kiem tra validation ben server
        if(empty($staff_email) || empty($staff_location) || empty($staff_name) || empty($staff_phone) || empty($staff_position)){
            $error = 1;
        }
        $sql_select_email_phone = <<<EOT
            SELECT * FROM nhanvien WHERE Email = '$staff_email' OR SoDienThoai = '$staff_phone';
        EOT;
        $query_select = mysqli_query($conn,$sql_select_email_phone);
        $result = mysqli_fetch_array($query_select,MYSQLI_ASSOC);
        if($result > 0){
            $error = 1;
        }
        if(!is_numeric($staff_phone) || strlen($staff_phone) != 10){
            $error = 1;
        }
        if($error == 0){
            $sql_insert_staff = <<<EOT
                INSERT INTO nhanvien(MSNV,HoTenNV,cv_id,DiaChi,SoDienThoai,Email,Password)
                VALUES ('$staff_id','$staff_name','$staff_position','$staff_location','$staff_phone','$staff_email','$staff_password_encode');
            EOT;
            if(mysqli_query($conn,$sql_insert_staff)){
                echo "<script>alert('Thêm mới thông tin nhân viên thành công')</script>";
                echo "<script>location.replace('/../../../../Amazing-PHP/admin/staff')</script>";
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
                    $mail->addAddress($staff_email);              
                    $mail->addReplyTo('congthienn1601@gmail.com');
                    $mail->isHTML(true);                                    
                    $mail->Subject = "Thông báo xác thực tài khoản nhân viên trên Amazing";         
                    $body = '
                        <div style="display: flex;justify-content: center; font-size: 17px;position: relative;top: 50%;transform: translateY(-60%);">
                            <div>
                                <div style="border: 1px solid black;min-height: 200px;display: inline-block;padding: 20px 20px 40px 20px;border-radius: 5px;">
                                    <div style="margin: 10px 0 20px;"><span style="font-size: 20px;">Amazing xin chào,</span></div>
                                    <div>Xin chào <span style="font-weight: 700;">'.$staff_name.'</span>, bạn vừa được tạo tài khoản '.$result_position['cv_ten'].' trên Amazing !</div>
                                    <div style="margin: 5px 0;">Đây là mật khẩu đăng nhập tài khoản của bạn:</div>
                                    <div style="font-size: 15px;font-style: italic;">(Bạn vui lòng không cung cấp mật khẩu này cho ai khác)</div>
                                    <div style="display: flex;justify-content: center;align-items: center;">
                                        <div style="border: 1px lightgray solid;display: inline-block;padding: 10px;margin: 30px 0;border-radius: 4px;font-weight: 600;color: blue;">
                                            '.$staff_password.'
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
        }else{
            echo "<script>alert('Thêm nhân viên thất bại, vui lòng kiểm tra lại')</script>";
            echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại!</h2>';
        }
    }
?>