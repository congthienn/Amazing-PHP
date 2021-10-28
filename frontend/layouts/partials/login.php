<?php
    if(session_id() ===""){
        session_start();
    }
    include_once __DIR__ . '/../../../../Amazing-PHP/backend/connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $email = inputdata($_GET['email_user']);
    $password = inputdata(sha1(sha1(md5(md5(sha1($_GET['password_user']))))));
    $remember_login = $_GET['remember_login'];
    $sql_select_staff = <<<EOT
        SELECT * FROM nhanvien WHERE Email = '$email' AND Password = '$password';
    EOT;
    $query_staff = mysqli_query($conn,$sql_select_staff);
    $result_staff = mysqli_fetch_array($query_staff,MYSQLI_ASSOC);

    $sql_select_user = <<<EOT
        SELECT * FROM khachhang WHERE EmailKH = '$email' AND Password = '$password';
    EOT;
    $query_user = mysqli_query($conn,$sql_select_user);
    $result_user = mysqli_fetch_array($query_user,MYSQLI_ASSOC);
    if(( $result_user == 0 ) && ( $result_staff == 0 )){
        echo json_encode("error");
    }else if($result_staff > 0){
        //Kiem tra Nhan vien
        if(!isset($_SESSION['user'])){
            $_SESSION['user'] = $result_staff['HoTenNV'];
            $_SESSION['email'] = $result_staff['Email'];
            $_SESSION['staff'] = 1;
        }else{
            $_SESSION['user'] = $result_staff['HoTenNV'];
            $_SESSION['email'] = $result_staff['Email'];
            $_SESSION['staff'] = 1;
        }
        if(strcmp($remember_login,'true')==0){
            setcookie("User",$_SESSION['user'],time()+(30*24*3600),'/');
            setcookie("Email",$_SESSION['email'],time()+(30*24*3600),'/');
            setcookie("Staff",$_SESSION['staff'],time()+(30*24*3600));
        }
        die(json_encode($result_staff['HoTenNV']));
    }else if($result_user > 0){
        //Kiem tra khach hang
        if(!isset($_SESSION['user'])){
            $_SESSION['user'] = $result_user['HoTenKH'];
            $_SESSION['email'] = $result_user['EmailKH'];
            $_SESSION['staff'] = 0;
        }else{
            $_SESSION['user'] = $result_usert['HoTenKH'];
            $_SESSION['email'] = $result_user['EmailKH'];
            $_SESSION['staff'] = 0;
        }
        if(strcmp($remember_login,'true')==0){
            setcookie("User",$_SESSION['user'],time()+(30*24*3600),'/');
            setcookie("Email",$_SESSION['email'],time()+(30*24*3600),'/');
            setcookie("Staff",$_SESSION['staff'],time()+(30*24*3600));
        }
        die(json_encode($result['HoTenKH']));
    }
?>