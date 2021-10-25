<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Edit Products</title>
    <link rel="stylesheet" href="/../Amazing-PHP/backend/products/add/product_add.css">
    <?php include_once __DIR__ . '/../../../../Amazing-PHP/assets/vendor/library.php'?>
</head>
<body>
    <?php
        include_once __DIR__ . '/../../connect_db.php';
        $product_id = $_GET['product_id'];
        $sql_select_product = <<<EOT
            SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
            ON hh.MaLoaiHang = lhh.MaLoaiHang WHERE MSHH = '$product_id'
        EOT;
        $query = mysqli_query($conn,$sql_select_product);
        $product = mysqli_fetch_array($query,MYSQLI_ASSOC);
    ?>
    <?php
        $sql_select_imgs = <<<EOT
            SELECT * FROM hinhhanghoa WHERE MSHH = '$product_id'
        EOT;
        $query_imgs = mysqli_query($conn,$sql_select_imgs);
        $data_img =[];
        while($row = mysqli_fetch_array($query_imgs,MYSQLI_ASSOC)){
            $data_img[] = array(
                'tenhinh' => $row['TenHinh']
            );
        }
    ?>
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
                            Chỉnh sửa thông tin hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/products/">Quản lí hàng hóa</a> / <a href="">Chỉnh sửa</a>
                        </div>
                    </div>
                    <div class="product_form">
                        <form action="processed_edit_product.php" enctype="multipart/form-data" id="formUpdate" name="formUpdate" method="POST">
                            <div class="product_name_price_img">
                                <div class="product_name_price">
                                    <div class="form-group">
                                        <label for="product_name"><strong>Tên sản phẩm</strong></label>
                                        <input type="text" name="product_name" id="product_name" value="<?=$product['TenHH']?>" class="form-control">
                                        <input type="text" name="product_id" id="product_id" value="<?=$product['MSHH']?>" hidden>
                                        <input type="text" name="parent_id" id="parent_id" value="<?=$product['STT']?>" hidden>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price"><strong>Giá bán</strong></label>
                                        <input type="number" name="product_price" id="product_price" class="form-control" min="0" value="<?=$product['Gia']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_quantity"><strong>Số lượng sản phẩm</strong></label>
                                        <input type="number" name="product_quantity" id="product_quantity" class="form-control" min="0" value="<?=$product['SoLuongHang']?>">
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
                                            <img src="/../Amazing-PHP/assets/uploads/products/<?=$product['TenHH']?>/<?=$product['HinhDaiDien']?>" alt="">
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
                                <div class="imgs_preview">
                                    <?php foreach($data_img as $img):?>
                                        <img src="/../Amazing-PHP/assets/uploads/products/<?=$product['TenHH']?>/<?=$img['tenhinh']?>" alt="">
                                    <?php endforeach?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_review">
                                    <strong>Giới thiệu tổng quan sản phẩm</strong>
                                </label>
                                <textarea name="product_review" id="product_review">
                                    <?=$product['GioiThieu']?>
                                </textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary" name="submit_form">Lưu thay đổi</button>
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
    <script src="product_edit.js"></script>
</body>
</html>