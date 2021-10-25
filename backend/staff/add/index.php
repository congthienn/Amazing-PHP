<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Add Staff</title>
    <link rel="stylesheet" href="staff_add.css">
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
                            Thêm mới nhân viên
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/staff/">Quản lí nhân viên</a> / Thêm nhân viên
                        </div>
                    </div>
                    <div class="col l-6">
                        <div class="form_insert">
                            <form action="processed_add_staff.php" name="formInsert" id="formInsert" method="POST">
                                <div class="form-group">
                                    <label for="staff_name"><strong>Họ và tên nhân viên</strong></label>
                                    <input type="text" name="staff_name" id="staff_name" class="form-control">
                                    <input type="text" name="staff_id" id="staff_id" value="" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="staff_mail"><strong>Địa chỉ email</strong></label>
                                    <input type="email" name="staff_mail" id="staff_mail" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="staff_phone"><strong>Số điện thoại</strong></label>
                                    <input type="tel" name="staff_phone" id="staff_phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="staff_position"><strong>Chức vụ</strong></label>
                                    <?php
                                        include_once __DIR__ . '/../../connect_db.php';
                                        $sql_select_position = <<<EOT
                                            SELECT * FROM chucvu
                                        EOT;
                                        $query = mysqli_query($conn,$sql_select_position);
                                        $data=[];
                                        while($result = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                                            $data[]=array(
                                                'cv_id' => $result['cv_id'],
                                                'cv_ten' => $result['cv_ten']
                                            );
                                        }
                                    ?>
                                    <select name="staff_position" id="staff_position" class="form-control">
                                        <option value=""></option>
                                        <?php foreach($data as $val):?>
                                            <option value="<?=$val['cv_id']?>"><?=$val['cv_ten']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="staff_location"><strong>Địa chỉ</strong></label>
                                    <input type="text" name="staff_location" id="staff_location" class="form-control">
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
    <script src="/../Amazing-PHP/backend/staff/add/staff_add.js"></script>
</body>
</html>