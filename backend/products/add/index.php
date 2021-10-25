<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Add Products</title>
    <link rel="stylesheet" href="product_add.css">
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
                            Thêm mới hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/products/">Quản lí hàng hóa</a> / <a href="">Thêm mới</a>
                        </div>
                    </div>
                    <div class="product_form">
                        <form action="processed_add_product.php" enctype="multipart/form-data" id="formInsert" name="formInsert" method="POST">
                            <div class="product_name_price_img">
                                <div class="product_name_price">
                                    <div class="form-group">
                                        <label for="product_name"><strong>Tên sản phẩm</strong></label>
                                        <input type="text" name="product_name" id="product_name" class="form-control">
                                        <input type="text" name="product_id" id="product_id" value="" hidden>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price"><strong>Giá bán</strong></label>
                                        <input type="number" name="product_price" id="product_price" class="form-control" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity"><strong>Số lượng sản phẩm</strong></label>
                                        <input type="number" name="product_quantity" id="product_quantity" class="form-control" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><strong>Loại sản phẩm</strong></label>
                                        <select name="category" id="category" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="product_img">
                                    <label for="product_img">
                                        <div class="btn_upload">
                                            <strong><i class="fas fa-folder-open icon_img"></i> Ảnh đại diện sản phẩm</strong>
                                        </div>
                                        <div class="img_container" id="img_container">
                                            <i class="fas fa-upload icon_upload"></i>
                                        </div>
                                    </label>
                                    <input type="file" id="product_img" name="product_img" style="width: 0px;" accept=".jpg, .png, .jpeg">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_imgs">
                                    <div class="btn_upload">
                                        <strong><i class="fas fa-cloud-upload-alt icon_img"></i> Ảnh sản phẩm chi tiết</strong>
                                    </div>
                                    
                                </label>
                                <input type="file" name="product_imgs[]" id="product_imgs" multiple style="width: 0px;" accept=".jpg, .png, .jpeg">
                                <div class="imgs_preview"></div>
                            </div>
                            <div class="form-group">
                                <label for="product_review">
                                    <strong>Giới thiệu tổng quan sản phẩm</strong>
                                </label>
                                <textarea name="product_review" id="product_review"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary" name="submit_form">Thêm mới</button>
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
    <script src="https://cdn.tiny.cloud/1/ul7nyaxhiomstzfeisqlpmaowrpjoo5nxp6nz4e6xi0fad8k/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="product_add.js"></script>
</body>
</html>