<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Add Category</title>
    <link rel="stylesheet" href="add_category.css">
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
                            Thêm loại hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/categories/">Loại hàng hóa</a> / Thêm mới
                        </div>
                    </div>
                    <div class="form_insert col l-6">
                        <form action="processed_add_category.php" name="formInsert" id="formInsert" method="POST">
                            <input type="text" value="0" readonly name="STT" id="STT" hidden>
                            <input type="text" value="0" readonly name="Parent_id" id="Parent_id" hidden>
                            <div class="form-group">
                                <label for="madanhmuc"><strong>Mã loại hàng hóa</strong></label>
                                <input type="text" id="madanhmuc" name="madanhmuc" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="tendanhmuc"><strong>Tên loại hàng hóa</strong></label>
                                <input type="text" id="tendanhmuc" name="tendanhmuc" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="danhmuccha"><strong>Thuộc loại hàng hóa</strong></label>
                                <select class="form-select form-control" aria-label="Default select example" name="danhmuccha" id="danhmuccha">
                                    <option value="0">Chọn danh mục loại hàng hóa</option>
                                </select>
                            </div>
                            <div>
                                <button class="btn btn-primary" name="submit_insert">Thêm mới</button>
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
    <script src="add_category.js"></script>
</body>
</html>