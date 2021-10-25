<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Products</title>
    <link rel="stylesheet" href="product_list.css">
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
</head>
<body>
    <div class="main">
        <div class="row no-gutters" style="position: relative;">
            <div class="col l-2 main_slidebar">
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/slidebar.php' ?>
                </div>
            </div>
            <div class="col l-10 main_content">
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
                </div>
                <div class="item_content">
                    <div class="item_header">
                        <div class="item_title">
                            Danh sách hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/products/">Quản lí hàng hóa</a>
                        </div>
                    </div>
                    <div class="product_list">
                        <div class="product_list--header">
                            <a href="/../Amazing-PHP/backend/products/add/" class="btn btn-primary">Thêm sản phẩm</a>
                        </div>
                        <div class="product_search">
                            <div class="select_category">
                                <?php
                                    include_once __DIR__ . '/../connect_db.php';
                                    $sql_select_category = <<<EOT
                                        SELECT * FROM loaihanghoa
                                    EOT;
                                    $query_category = mysqli_query($conn,$sql_select_category);
                                    $data_category = [];
                                    while($result_category = mysqli_fetch_array($query_category,MYSQLI_ASSOC)){
                                        $data_category[] = array(
                                            'mlh' => $result_category['MaLoaiHang'],
                                            'tlh' => $result_category['TenLoaiHang'],
                                            'stt' => $result_category['STT']
                                        );
                                    }
                                ?>
                                <select name="" id="select_category">
                                    <option value="">Danh mục sản phẩm</option>
                                    <?php foreach($data_category as $val_category):?>
                                        <option value="<?=$val_category['stt']?>"><?=$val_category['tlh']?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="search_product_name">
                                <input type="text" class="form-control" id="search_product_name" placeholder="Tên sản phẩm - Mã sản phẩm">
                            </div>
                        </div>
                        <div class="product_list--content">
                            <?php 
                                //Select sum
                                $sql_sum = <<<EOT
                                    SELECT COUNT(*) tonghh FROM hanghoa
                                EOT;
                                $query_sum = mysqli_query($conn,$sql_sum);
                                $result_sum = mysqli_fetch_array($query_sum,MYSQLI_ASSOC);
                                $TOTAL_COUNT = $result_sum['tonghh'];
                                $ROW_PAGE = 4;
                                $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
                                $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
                                $OFFSET = ($PAGE - 1)*$ROW_PAGE;
                                //Select product
                                $sql_select_product = <<<EOT
                                    SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
                                    ON hh.MaLoaiHang = lhh.MaLoaiHang LIMIT $OFFSET,$ROW_PAGE;
                                EOT;
                                $query = mysqli_query($conn,$sql_select_product);
                                $data_product = [];
                                while($result = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                                    $data_product[] =array(
                                        'mshh' => $result['MSHH'],
                                        'tenhh' => $result['TenHH'],
                                        'gia' => $result['Gia'],
                                        'soluong' => $result['SoLuongHang'],
                                        'hinhanh' => $result['HinhDaiDien'],
                                        'tenloaihang' => $result['TenLoaiHang']
                                    );
                                }
                            ?>
                            <table class="table">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th width="30%">Sản phẩm</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th>Số lượng trong kho</th>
                                    <th></th>
                                </thead>
                                <tbody id="result_product">
                                    <?php $i =0 ;?>
                                    <?php foreach($data_product as $val):?>
                                        <?php $i++?>
                                        <tr>
                                            <td><strong><?=$i?></strong></td>
                                            <td class="product_img_name">
                                                <div><img src="/../Amazing-PHP/assets/uploads/products/<?=$val['tenhh']?>/<?=$val['hinhanh']?>" alt="" width="65px"></div>
                                                <div style="margin-left: 10px;">
                                                    <div class="product_name"><?=$val['tenhh']?></div>
                                                    <div style="font-style: italic;"><?=$val['tenloaihang']?></div>
                                                </div>
                                               
                                            </td>
                                            <td><strong><?=$val['mshh']?></strong></td>
                                            <td class="product_price"><?=number_format($val['gia'],0,',','.')?>đ</td>
                                            <td class="product_quantity"><?=$val['soluong']?> sản phẩm</td>
                                            <td>
                                                <div class="action">
                                                    <span class="btn btn-info btn-sm btn_show" data-product_id="<?=$val['mshh']?>">Chi tiết</span>
                                                    <a href="/../Amazing-PHP/backend/products/edit/?product_id=<?=$val['mshh']?>" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                                                    <span class="btn btn-danger btn-sm btn-delete" data-product_id="<?=$val['mshh']?>" data-product_name="<?=$val['tenhh']?>">Xóa</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                            <?php
                                $previous = ($PAGE == 1) ? 1 :  $PAGE - 1;
                                $next = ($PAGE == $TOTAL_PAGE) ? $PAGE : $PAGE + 1;
                            ?>
                            <div class="paginate">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link text-dark" href="?page=<?=$previous?>"><i class="fas fa-angle-double-left"></i></a></li>
                                    <?php for($i = 1;$i<=$TOTAL_PAGE;$i++):?>
                                        <li class=" page-item"><a class="page-link text-dark" href="?page=<?=$i?>"><?=$i?></a></li>
                                    <?php endfor;?>
                                    <li class="page-item"><a class="page-link text-dark" href="?page=<?=$next?>"><i class="fas fa-angle-double-right"></i></a></li>
                                </ul>
                            </div>
                    </div>
                </div>
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/footer.php'?>
                </div>
            </div>
         <div id="product_show"></div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/select2/select2.css">
    <script src="/../Amazing-PHP/assets/vendor/select2/select2.min.js"></script>
    <script src="/../Amazing-PHP/backend/products/product_list.js"></script>
    <script>
        $(document).ready(function(){
            $("#select_category").select2();
            $("#search_product_name").keyup(function(){
                $("#select_category").val('');
                $("#select2-select_category-container").text('Danh mục sản phẩm');
                var text = 1;
                var key = $(this).val();
                var page = <?=$PAGE?>;
                $.ajax({
                    type: "GET",
                    url: "search_product.php",
                    data:{
                        key,page,text
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_product").html(response);
                    }
                });
            });
            $("#select_category").change(function(){
                $("#search_product_name").val('');
                var key = $(this).val();
                var text =0;
                $.ajax({
                    type: "GET",
                    url: "search_product.php",
                    data:{
                        key,text
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_product").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>