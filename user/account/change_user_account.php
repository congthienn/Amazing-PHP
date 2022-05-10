<?php
    if(session_id()===""){
        session_start();
    }
    include_once __DIR__ . '/../../admin/connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $name = $_POST["name"];
    $email = $_SESSION["email"];
    $phone = $_POST["phone"];
    $old_password = $_POST["old_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $change_password = $_POST["change_password"];
    $sql_select_phone = <<<EOT
        SELECT * FROM khachhang WHERE EmailKH !="$email" AND SoDienThoai = "$phone"
    EOT;
    $query_select_user = mysqli_query($conn,$sql_select_phone);
    $result_user = mysqli_fetch_array($query_select_user,MYSQLI_ASSOC);
    $data_result=[];
    $error = false;
    if(empty($name)){
        $error = true;
        $data_result["error"] = true;
        $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Tên tài khoản không được để trống';
        echo json_encode($data_result);
    }else if(empty($phone)){
        $error = true;
        $data_result["error"] = true;
        $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Số điện thoại không được để trống';
        echo json_encode($data_result);
    }else if($result_user > 0){
        $error = true;
        $data_result["error"] = true;
        $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Số điện thoại đã được đăng ký, vui lòng kiểm tra lại';
        echo json_encode($data_result);
    }else if($change_password == "true"){
        $password = inputdata(sha1(sha1(md5(md5(sha1($old_password))))));
        $sql_select_phone = <<<EOT
            SELECT * FROM khachhang WHERE EmailKH ="$email" AND Password = "$password"
        EOT;
        $query_select_user = mysqli_query($conn,$sql_select_phone);
        $result_user = mysqli_fetch_array($query_select_user,MYSQLI_ASSOC);
        if($result_user == 0 || empty($old_password)){
            $error = true;
            $data_result["error"] = true;
            $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Mật khẩu không chính xác';
            echo json_encode($data_result);
        }else if(empty($new_password)){
            $error = true;
            $data_result["error"] = true;
            $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Mật khẩu mới không được để trống';
            echo json_encode($data_result);
        }else if(strcmp($new_password,$confirm_password) != 0){
            $data_result["error"] = true;
            $error = true;
            $data_result["message"] = '<i class="fas fa-exclamation-triangle"></i> Mật khẩu mới không khớp nhau';
            echo json_encode($data_result);
        }
    }
    if(!$error){
        if($change_password== "true"){
            $password = inputdata(sha1(sha1(md5(md5(sha1($new_password))))));
            $sql_update = <<<EOT
                UPDATE khachhang SET HoTenKH = '$name',Password = '$password',SoDienThoai="$phone" WHERE EmailKH="$email"
            EOT;
            mysqli_query($conn,$sql_update);
        }else{
            $sql_update = <<<EOT
                UPDATE khachhang SET HoTenKH = '$name',SoDienThoai="$phone" WHERE EmailKH="$email"
            EOT;
            mysqli_query($conn,$sql_update);
        }
        $_SESSION['user'] = $name;
        if(isset($_COOKIE['User']) && !empty($_COOKIE['User'])){
            setcookie("User",$_SESSION['user'],time()+(30*24*3600),'/');
        }
        $data_result["error"] = false;
        echo json_encode($data_result);
    }
?>