<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(!isset($_SESSION["email"])):?>
    <script>location.replace("/../Amazing-PHP/user/")</script>
<?php else:?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Thông tin tài khoản</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/user/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/user/cart/">Thông tin tài khoản</a>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide" >
                <div class="row">
                    <div class="col l-3">
                        <div>
                            <ul class="sildebar_account">
                                <li class="sildebar--item"><a href="/../Amazing-PHP/user/account/"><i class="fas fa-user"></i> Tài khoản của tôi</a></li>
                                <li class="sildebar--item"><a href="purchase.php"><i class="far fa-file"></i> Danh sách các đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col l-9" >
                        <div class="container_account">
                            <div class="title">
                                Thông tin tài khoản của bạn
                            </div>
                            <span>Quản lý thông tin hồ sơ để bảo mật tài khoản</span>
                            <div class="account_information">
                                <?php
                                    include_once __DIR__ . '/../../admin/connect_db.php';
                                    $email = $_SESSION['email'];
                                    $sql_select_user = <<<EOT
                                        SELECT * FROM khachhang WHERE EmailKH ="$email"
                                    EOT;
                                    $query_select_user = mysqli_query($conn,$sql_select_user);
                                    $result_user = mysqli_fetch_array($query_select_user,MYSQLI_ASSOC);
                                    $user_id = $result_user["MSKH"];
                                ?>
                                <div class="information--item">
                                    <div class="label-item">Tên tài khoản</div>
                                    <div class="item-edit name"><span class="value"><?=$result_user["HoTenKH"]?><input type="hidden" id="name" name="name" value="<?=$result_user["HoTenKH"]?>"></span>  <i class="fas fa-pen-square edit icon" data-name="name"></i></div>
                                </div>
                                <div class="information--item">
                                    <div class="label-item">Địa chỉ email</div>
                                    <div ><span><?=$result_user["EmailKH"]?></span> </div>
                                </div>
                                <div class="information--item">
                                    <div class="label-item">Số điện thoại</div>
                                    <div class="item-edit phone"><span class="value"><?=$result_user["SoDienThoai"]?><input type="hidden" id="phone" name="phone" value="<?=$result_user["SoDienThoai"]?>"></span> <i class="fas fa-pen-square edit icon" data-name="phone"></i></div>
                                </div>
                                <div class="information--item__changepassword">
                                    <div class="label-item change_password">Đổi mật khẩu </div>
                                    <div class="item-edit">
                                        <div class="container_change_password">
                                                <input type="password" class="text-password" name="old_password" id="old_password" placeholder="Mật khẩu cũ">
                                                <input type="password" class="text-password" name="new_password" id="new_password" placeholder="Mật khẩu mới">
                                                <input type="password" class="text-password" name="confirm_password" id="confirm_password" placeholder="Xác nhận lại mật khẩu">
                                        </div>
                                    </div>
                                </div>
                                <div style="margin: 10px 0;">
                                    <span id="error"></span>
                                </div>
                                <div style="margin-top:20px" class="container-btn">
                                    <button class="btn-account save">Lưu thay đổi</button>
                                    <button class="btn-account cancel" data-name="<?=$result_user["HoTenKH"]?>" data-phone="<?=$result_user["SoDienThoai"]?>">Hủy bỏ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/footer.php'?>
    </div>
    <script src="account.js"></script>
</body>
</html>
<?php endif;?>