<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Staff</title>
    <link rel="stylesheet" href="staff_list.css">
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
                            Danh sách nhân viên
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/staff/">Quản lí nhân viên</a>
                        </div>
                    </div>
                    <div class="staff_list">
                        <div class="staff_list--header">
                            <a href="/../Amazing-PHP/admin/staff/add/" class="btn btn-primary">Thêm nhân viên</a>
                        </div>
                        <div class="search_staff">
                            <input type="text" id="search_staff" class="form-control" placeholder="Tên nhân viên - Số điện thoại">
                        </div>
                        <div class="staff_list--content">
                            <?php
                                include_once __DIR__ . '/../connect_db.php';
                                $sql_sum_count = <<<EOT
                                    SELECT COUNT(*) tongnv FROM nhanvien
                                EOT;
                                $query_sum_count = mysqli_query($conn,$sql_sum_count);
                                $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
                                $TOTAL_COUNT = $result_sum_count['tongnv'];
                                $ROW_PAGE = 5;
                                $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
                                $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
                                $OFFSET = ($PAGE - 1) * $ROW_PAGE;
                                $sql_select_staff = <<<EOT
                                    SELECT * FROM nhanvien nv JOIN chucvu cv ON nv.cv_id = cv.cv_id LIMIT $OFFSET,$ROW_PAGE
                                EOT;
                                $query_select = mysqli_query($conn,$sql_select_staff);
                                $data_staff =[];
                                while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
                                    $data_staff[] = array(
                                        'msnv' => $result['MSNV'],
                                        'hoten' => $result['HoTenNV'],
                                        'chucvu' => $result['cv_ten'],
                                        'sodienthoai' => $result['SoDienThoai'],
                                        'email' => $result['Email']
                                    );
                                }
                                $i=0;
                            ?>
                            <table class="table">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th width="12%">Mã nhân viên</th>
                                    <th>Nhân viên</th>
                                    <th>Địa chỉ Email</th>
                                    <th>Số điện thoại</th>
                                    <th></th>
                                </thead>
                                <tbody id="result_staff">
                                    <?php foreach($data_staff as $val):?>
                                        <?php $i++;?>
                                        <tr>
                                            <td><strong><?=$i?></strong></td>
                                            <td><strong><?=$val['msnv']?></strong></td>
                                            <td>
                                                <strong><?=$val['hoten']?></strong></br>
                                                <span class="staff_position"><?=$val['chucvu']?></span>
                                            </td>
                                            <td><span class="staff_email"><?=$val['email']?></span></td>
                                            <td><span class="staff_number"><?=$val['sodienthoai']?></span></td>
                                            <td>
                                                <div class="action">
                                                    <a href="/../Amazing-PHP/admin/staff/edit/?staff_id=<?=$val['msnv']?>" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                                                    <span class="btn btn-danger btn-sm btn_delete" data-staff_id="<?=$val['msnv']?>">Xóa</span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
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
                </div>
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
                </div>
            </div>
         <div id="product_show"></div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/admin/staff/delete_staff.js"></script>
    <script>
        $(document).ready(function(){
            $("#search_staff").keyup(function(){
                var key = $(this).val();
                var page = <?=$PAGE?>;
                $.ajax({
                    type: "GET",
                    url: "search_staff.php",
                    data:{
                        key,page
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_staff").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>