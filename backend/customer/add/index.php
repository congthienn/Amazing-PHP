<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Add Customer</title>
    <link rel="stylesheet" href="customer_add.css">
    <?php include_once __DIR__ . '/../../../../Amazing-PHP/assets/vendor/library.php'?>
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
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/customer/">Danh sách khách hàng</a> / Thêm khách hàng
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="form_insert">
                            <form action="processed_add_customer.php" name="formInsert" id="formInsert" method="POST">
                                <div class="form-group">
                                    <label for="customer_name"><strong>Họ và tên khách hàng</strong></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control">
                                    <input type="text" name="customer_id" id="customer_id" value="" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email"><strong>Địa chỉ email</strong></label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone"><strong>Số điện thoại</strong></label>
                                    <input type="tel" name="customer_phone" id="customer_phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="customer_company"><strong>Tên công ty (Nếu có)</strong></label>
                                    <input type="text" name="customer_company" id="customer_company" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="customer_fax"><strong>Số Fax (Nếu có)</strong></label>
                                    <input type="text" name="customer_fax" id="customer_fax" class="form-control">
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
    <script src="customer_add.js"></script>
</body>
</html>

