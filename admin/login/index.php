<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(!isset($_SESSION["staff"])):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <title>Amazing | Admin</title>
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="login">
    <div class="login_container"></div>
    <div class="login_content">
        <div class="login_content--header">
            <a class="logo">
                <img src="/../Amazing-PHP/assets/uploads/AdminLTELogo.png" width="80px">
            </a>
            <div class="text_title">
                Amazing Admin
            </div>
        </div>
        <div class="login_content--form">
            <div class="form--item">
                <label for="email" class="label_login"><i class="fas fa-envelope"></i> Email</label>
                <div class="container--input">
                    <input type="email" id="email" class="from--input">
                </div>
            </div>
            <div class="form--item">
                <label for="password" class="label_login"><i class="fas fa-lock"></i> Mật khẩu</label>
                <div class="container--input">
                    <input type="password" id="password" class="from--input">
                    <div class="show_password"><label for="show_password"><span id="eyes"><i class="fas fa-eye-slash"></i></span></label></div>
                    <input type="checkbox" id="show_password" hidden>
                </div>
            </div>
            <div id="error_login"></div>
            <div class="form--item remember_login">
                <input type="checkbox" id="remember_login" value="1">
                <label for="remember_login">Ghi nhớ đăng nhập</label>
            </div>
            <button class="btn_login btn_login--user">Đăng nhập</button>
        </div>
    </div>
</div>
<script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
<script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="login.js"></script>
</body>
</html>
<?php endif; ?>
