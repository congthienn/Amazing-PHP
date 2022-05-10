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
    <title>Amazing | Customer</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
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
                        <!-- <div class="search_customer">
                            <input type="text" id="search_customer" class="form-control" placeholder="Tên khách hàng - Số điện thoại">
                        </div> -->
                        <div class="customer_list--content">
                            <?php
                                include_once __DIR__ . '/../connect_db.php';
                                $sql_select_customer = <<<EOT
                                    SELECT * FROM khachhang
                                EOT;
                                $query_select = mysqli_query($conn,$sql_select_customer);
                                $data_customer =[];
                                while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
                                    $data_customer[] = array(
                                        'mskh' => $result['MSKH'],
                                        'hoten' => $result['HoTenKH'],
                                        'sodienthoai' => $result['SoDienThoai'],
                                        'email' => $result['EmailKH'],
                                    );
                                }
                                $i=0;
                            ?>
                            <table class="table" id="list_customer">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th width="15%">Mã khách hàng</th>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#list_customer").DataTable();
        });
    </script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>
