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
        $error = 0;
        $staff_id = inputdata($_POST['staff_id']);
        $staff_name = inputdata($_POST['staff_name']);
        $staff_email = inputdata($_POST['staff_mail']);
        $staff_phone = inputdata($_POST['staff_phone']);
        $staff_location = inputdata($_POST['staff_location']);
        $staff_position = inputdata($_POST['staff_position']);
        $staff_email_old = inputdata($_POST['staff_mail_old']);
        $sql_select_position = <<<EOT
            SELECT * FROM chucvu WHERE cv_id = '$staff_position';
        EOT;
        $query_position = mysqli_query($conn,$sql_select_position);
        $staff_password = rand_string_password();
        $staff_password_encode = sha1(sha1(md5(md5(sha1($staff_password)))));
        $result_position = mysqli_fetch_array($query_position,MYSQLI_ASSOC);
        //Kiem tra validation ben server
        if(empty($staff_email) || empty($staff_location) || empty($staff_name) || empty($staff_phone) || empty($staff_position)){
            $error = 1;
        }
        $sql_select_email_phone = <<<EOT
            SELECT * FROM nhanvien WHERE (Email = '$staff_email' OR SoDienThoai = '$staff_phone') AND MSNV != '$staff_id';
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
                $sql_update_staff = <<<EOT
                    UPDATE nhanvien SET HoTenNV = '$staff_name',DiaChi = '$staff_location',SoDienThoai = '$staff_phone',
                    cv_id = '$staff_position' WHERE MSNV = '$staff_id';
                EOT;
                mysqli_query($conn,$sql_update_staff);
            if(strcmp($staff_email_old,$staff_email)==0){
                echo "<script>alert('Câp nhật thông tin nhân viên thành công')</script>";
                echo "<script>location.replace('/../../../../Amazing-PHP/backend/staff')</script>";
            }else{
                $staff_password = rand_string_password();
                $staff_password_encode = sha1(sha1(md5(md5(sha1($staff_password)))));
                $sql_update_mail = <<<EOT
                    UPDATE nhanvien SET Email = '$staff_email',Password = '$staff_password_encode' WHERE MSNV = '$staff_id'
                EOT;
                if(mysqli_query($conn,$sql_update_mail)){
                    echo "<script>alert('Thêm mới thông tin nhân viên thành công')</script>";
                    echo "<script>location.replace('/../../../../Amazing-PHP/backend/staff')</script>";
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
                                        <div>Xin chào <span style="font-weight: 700;">'.$staff_name.'</span>, tài khoản '.$result_position['cv_ten'].' của bạn trên Amazing vừa được cập nhật thành công!</div>
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
            }
            
        }else{
            echo "<script>alert('Cập nhật thông tin thất bại, vui lòng kiểm tra lại')</script>";
            echo '<h2 style="color:red">Đã xảy ra lỗi vui lòng kiểm tra lại !</h2>';
        }
    }
?>