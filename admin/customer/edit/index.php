<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(isset($_SESSION["staff"])):?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Edit Customer</title>
    <link rel="stylesheet" href="/../Amazing-PHP/admin/customer/add/customer_add.css">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <?php include_once __DIR__ . '/../../../../Amazing-PHP/assets/vendor/library.php'?>
    <?php
        include_once __DIR__ . '/../../connect_db.php';
        $customer_id = $_GET['customer_id'];
        $sql_select_customer = <<<EOT
            SELECT * FROM khachhang WHERE MSKH = '$customer_id';
        EOT;
        $query = mysqli_query($conn,$sql_select_customer);
        $result_customer = mysqli_fetch_array($query,MYSQLI_ASSOC);
        if(empty($result_customer['TenCongTy'])){
            $company = '';
        }else{
            $company = $result_customer['TenCongTy'];
        }
        if(empty($result_customer['SoFax'])){
            $sofax = '';
        }else{
            $sofax = $result_customer['SoFax'];
        }
    ?>
</head>
<body>
    <div class="main">
        <div class="row no-gutters">
            <div class="col l-2 main_slidebar">
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/slidebar.php' ?>
                </div>
            </div>
            <div class="col l-10 main_content">
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/header.php' ?>
                </div>
                <div class="item_content">
                    <div class="item_header">
                        <div class="item_title">
                            Thêm mới khách hàng
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/customer/">Danh sách khách hàng</a> / Chỉnh sửa thông tin
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="form_insert">
                            <form action="processed_edit_customer.php" name="formInsert" id="formInsert" method="POST">
                                <div class="form-group">
                                    <label for="customer_name"><strong>Họ và tên khách hàng</strong></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="<?=$result_customer['HoTenKH']?>">
                                    <input type="text" name="customer_id" id="customer_id" value="<?=$result_customer['MSKH']?>" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email"><strong>Địa chỉ email</strong></label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control" value="<?=$result_customer['EmailKH']?>">
                                    <input type="email" name="customer_email_old" id="customer_email_old" class="form-control" readonly hidden value="<?=$result_customer['EmailKH']?>">
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone"><strong>Số điện thoại</strong></label>
                                    <input type="tel" name="customer_phone" id="customer_phone" class="form-control" value="<?=$result_customer['SoDienThoai']?>">
                                </div>
                                <div>
                                    <button class="btn btn-primary" name="submit_form">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/footer.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.validate.min.js"></script>
    <script src="/../Amazing-PHP/admin/customer/add/customer_add.js"></script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>


