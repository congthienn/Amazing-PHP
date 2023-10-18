<?php
    if(session_id() ===""){
        session_start();
    }
    include_once __DIR__ . '/../connect_db.php';
    function inputdata($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $email = inputdata($_GET['email_user']);
    $password = inputdata(sha1(sha1(md5(md5(sha1($_GET['password_user']))))));
    $remember_login = $_GET['remember_login'];
    $sql_select_user = <<<EOT
        SELECT * FROM nhanvien WHERE Email = '$email' AND Password = 'ddb25769880dc6553eee75f4505fb4fca0293489';
    EOT;
    $query_user = mysqli_query($conn,$sql_select_user);
    $result_user = mysqli_fetch_array($query_user,MYSQLI_ASSOC);
    if(( $result_user == 0 )){
        echo json_encode("error");
    }else if($result_user > 0){
        //Kiem tra khach hang
        if(!isset($_SESSION['staff'])){
            $_SESSION['staff'] = $result_user['HoTenNV'];
            $_SESSION['email_staff'] = $result_user['Email'];
        }else{
            $_SESSION['staff'] = $result_user['HoTenNV'];
            $_SESSION['email_staff'] = $result_user['Email'];
        }
        if(strcmp($remember_login,'true')==0){
            setcookie("Staff",$_SESSION['staff'],time()+(30*24*3600),'/');
            setcookie("Email_staff",$_SESSION['email_staff'],time()+(30*24*3600),'/');
        }
        echo json_encode("success");
    }
?>