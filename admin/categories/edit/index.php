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
    <title>Amazing | Add Category</title>
    <link rel="stylesheet" href="/../Amazing-PHP/admin/categories/add/add_category.css">
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
                <div class="main_insert">
                    <div class="item_header">
                        <div class="item_title">
                            Chỉnh loại hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/categories/">Loại hàng hóa</a> / Chỉnh sửa
                        </div>
                    </div>
                    <div class="form_insert col l-6">
                        <?php
                            include_once __DIR__ . '/../../connect_db.php';
                            $maloaihang = $_GET['maloaihanghoa'];
                            $sql_select_ma = <<<EOT
                                SELECT * FROM loaihanghoa WHERE MaLoaiHang = '$maloaihang';
                            EOT;
                            $query = mysqli_query($conn,$sql_select_ma);
                            $reuslt = mysqli_fetch_array($query,MYSQLI_ASSOC);
                        ?>
                        <form action="update.php" name="formInsert" id="formInsert" method="POST">
                            <input type="text" value="<?=$reuslt['STT']?>" readonly name="STT" id="STT" hidden>
                            <input type="text" value="<?=$reuslt['Parent']?>" readonly name="Parent_id" id="Parent_id" hidden>
                            <div class="form-group">
                                <!-- <label for="madanhmuc"><strong>Mã loại hàng hóa</strong></label> -->
                                <input type="text" id="madanhmuc" name="madanhmuc" class="form-control" value="<?=$reuslt['MaLoaiHang']?>" readonly hidden>
                            </div>
                            <div class="form-group">
                                <label for="tendanhmuc"><strong>Tên loại hàng hóa</strong></label>
                                <input type="text" id="tendanhmuc" name="tendanhmuc" class="form-control" value="<?=$reuslt['TenLoaiHang']?>">
                            </div>
                            <div class="form-group">
                                <label for="danhmuccha"><strong>Thuộc loại hàng hóa</strong></label>
                                <select class="form-select form-control" aria-label="Default select example" name="danhmuccha" id="danhmuccha">
                                    <option value="0">Chọn loại hàng hóa</option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary" name="submit_insert">Lưu thay đổi</button>
                            </div>
                        </form>
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
    <script src="/../Amazing-PHP/admin/categories/add/add_category.js"></script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>