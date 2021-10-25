<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Categories</title>
    <link rel="stylesheet" href="list_categories.css">
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
</head>
<body>
    <div class="main">
        <div class="row no-gutters">
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
                            Danh mục hàng hóa
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/categories/">Loại hàng hóa</a>
                        </div>
                    </div>
                    <div class="category_list">
                        <div class="category_insert">
                            <a href="/../Amazing-PHP/backend/categories/add/" class="btn btn-primary">Thêm loại sản phẩm</a>
                        </div>
                        <div class="search_categories">
                            <input type="text" class="form-control" id="search_category" placeholder="Tên danh mục loại hàng hóa">
                        </div>
                        <table class="table">
                            <thead class="bg-dark text-white">
                                <th width="5%">STT</th>
                                <th width="15%">Mã loại hàng hóa</th>
                                <th>Danh mục loại hàng hóa</th>
                                <th></th>
                            </thead>
                            <tbody id="result_search">
                                <?php
                                    include_once __DIR__ . '/../connect_db.php';
                                    $sql_sum_count = <<<EOT
                                        SELECT COUNT(*) tonglhh FROM loaihanghoa
                                    EOT;
                                    $query_sum_count = mysqli_query($conn,$sql_sum_count);
                                    $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
                                    $TOTAL_COUNT = $result_sum_count['tonglhh'];
                                    $ROW_PAGE = 6;
                                    $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
                                    $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $OFFSET = ($PAGE - 1) * $ROW_PAGE;
                                    $sql_select_category = <<<EOT
                                        SELECT * FROM loaihanghoa LIMIT $OFFSET,$ROW_PAGE
                                    EOT;
                                    $query_select = mysqli_query($conn,$sql_select_category);
                                    while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
                                        $data_category []= array(
                                            'maloaihang' => $result['MaLoaiHang'],
                                            'tenloaihang' => $result['TenLoaiHang'],
                                            'parent' => $result['Parent'],
                                            'stt' => $result['STT']
                                        );
                                    }
                                    $i = 0;
                                ?>
                                <?php if(!empty($data_category)):?>
                                    <?php foreach($data_category as $val):?>
                                        <?php $i++;?>
                                        <tr class="parent_<?=$val['parent']?>">
                                            <td><strong><?=$i?></strong></td>
                                            <td><div class="category_id"><?=$val['maloaihang']?></div></td>
                                            <td class="category_name"><?=$val['tenloaihang']?></td>
                                            <td>
                                                <span class="btn btn-danger action btn-sm btn-delete" data-id="<?=$val['maloaihang']?>" data-stt="parent_<?=$val['stt']?>">Xóa</span>
                                                <a href="/../Amazing-PHP/backend/categories/edit/?maloaihanghoa=<?=$val['maloaihang']?>" class="btn btn-secondary action btn-sm" style="margin-right: 5px;">Chỉnh sửa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                        <div>
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
                    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/backend/categories/list_category.js"></script>
    <script>
        $(document).ready(function(){
            $("#search_category").keyup(function(){
                var search = $(this).val();
                var page = <?=$PAGE?>;
                $.ajax({
                    type: "GET",
                    url: "search_category.php",
                    data:{
                        search,page
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#result_search').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>