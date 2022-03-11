<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Customer</title>
    <link rel="stylesheet" href="customer_list.css">
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
                            Danh sách khách hàng
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/customer/">Danh sách khách hàng</a>
                        </div>
                    </div>
                    <div class="customer_list">
                        <div class="customer_list--header">
                            <a href="/../Amazing-PHP/admin/customer/add/" class="btn btn-primary">Thêm khách hàng</a>
                        </div>
                        <div class="search_customer">
                            <input type="text" id="search_customer" class="form-control" placeholder="Tên khách hàng - Số điện thoại">
                        </div>
                        <div class="customer_list--content">
                            <?php
                                include_once __DIR__ . '/../connect_db.php';
                                $sql_sum_count = <<<EOT
                                    SELECT COUNT(*) tongkh FROM khachhang
                                EOT;
                                $query_sum_count = mysqli_query($conn,$sql_sum_count);
                                $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
                                $TOTAL_COUNT = $result_sum_count['tongkh'];
                                $ROW_PAGE = 5;
                                $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
                                $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
                                $OFFSET = ($PAGE - 1) * $ROW_PAGE;
                                $sql_select_customer = <<<EOT
                                    SELECT * FROM khachhang LIMIT $OFFSET , $ROW_PAGE
                                EOT;
                                $query_select = mysqli_query($conn,$sql_select_customer);
                                $data_customer =[];
                                while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
                                    $data_customer[] = array(
                                        'mskh' => $result['MSKH'],
                                        'hoten' => $result['HoTenKH'],
                                        'sodienthoai' => $result['SoDienThoai'],
                                        'email' => $result['EmailKH'],
                                        'congty' => $result['TenCongTy'],
                                        'sofax' => $result['SoFax']
                                    );
                                }
                                $i=0;
                            ?>
                            <table class="table">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th width="13%">Mã khách hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Địa chỉ Email</th>
                                    <th>Số điện thoại</th>
                                    <th></th>
                                </thead>
                                <tbody id="result_customer">
                                    <?php foreach($data_customer as $val):?>
                                        <?php $i++;?>
                                        <tr>
                                            <td><strong><?=$i?></strong></td>
                                            <td><strong><?=$val['mskh']?></strong></td>
                                            <td>
                                                <strong><?=$val['hoten']?></strong></br>
                                                <?php if(!empty($val['congty'])):?>
                                                    <div class="company"><?=$val['congty']?></div>
                                                <?php endif;?>
                                                <?php if(!empty($val['sofax'])):?>
                                                    <div class="company">Số Fax: <?=$val['sofax']?></div>
                                                <?php endif;?>
                                            </td>
                                            <td><span class="customer_email"><?=$val['email']?></span></td>
                                            <td><span class="customer_number"><?=$val['sodienthoai']?></span></td>
                                            <td>
                                                <div class="action">
                                                    <a href="/../Amazing-PHP/admin/customer/edit/?customer_id=<?=$val['mskh']?>" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
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
    <script>
        $(document).ready(function(){
            $("#search_customer").keyup(function(){
                var key = $(this).val();
                var page = <?=$PAGE?>;
                $.ajax({
                    type: "GET",
                    url: "search_customer.php",
                    data:{
                        key,page
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_customer").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>