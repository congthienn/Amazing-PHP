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
    <title>Amazing | Categories</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
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
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/categories/">Loại hàng hóa</a>
                        </div>
                    </div>
                    <div class="category_list">
                        <div class="category_insert">
                            <a href="/../Amazing-PHP/admin/categories/add/" class="btn btn-primary">Thêm loại sản phẩm</a>
                        </div>
                        <!-- <div class="search_categories">
                            <input type="text" class="form-control" id="search_category" placeholder="Tên danh mục loại hàng hóa">
                        </div> -->
                        <table class="table" id="list_category">
                            <thead class="bg-dark text-white">
                                <th width="5%">STT</th>
                                <th width="20%">Mã loại hàng hóa</th>
                                <th>Danh mục loại hàng hóa</th>
                                <th></th>
                            </thead>
                            <tbody id="result_search">
                                <?php
                                    include_once __DIR__ . '/../connect_db.php';
                                    // $sql_sum_count = <<<EOT
                                    //     SELECT COUNT(*) tonglhh FROM loaihanghoa
                                    // EOT;
                                    // $query_sum_count = mysqli_query($conn,$sql_sum_count);
                                    // $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
                                    // $TOTAL_COUNT = $result_sum_count['tonglhh'];
                                    // $ROW_PAGE = 6;
                                    // $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
                                    // $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
                                    // $OFFSET = ($PAGE - 1) * $ROW_PAGE;
                                    $sql_select_category = <<<EOT
                                        SELECT * FROM loaihanghoa 
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
                                                <a href="/../Amazing-PHP/admin/categories/edit/?maloaihanghoa=<?=$val['maloaihang']?>" class="btn btn-secondary action btn-sm" style="margin-right: 5px;">Chỉnh sửa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div> 
                </div>
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>

    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/admin/categories/list_category.js"></script>
    <script>
        $(document).ready(function(){
            $("#list_category").DataTable();
        });
    </script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>