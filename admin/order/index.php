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
    <title>Amazing | Order</title>
    <link rel="stylesheet" href="order_list.css">
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
    <?php
        include_once __DIR__ . '/../connect_db.php';
        $sql_select_order  = <<<EOT
            SELECT * FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH ORDER BY dh.TrangThaiDH ASC
        EOT;
        $query_order = mysqli_query($conn,$sql_select_order);
        $data_order =[];
        while($row = mysqli_fetch_array($query_order,MYSQLI_ASSOC)){
            $data_order[] = array(
                'mdh' => $row['SoDonDH'],
                'dcnh' => $row['DiaChiNhanHang'],
                'kh' => $row['HoTenKH'],
                'sdt' => $row['SoDienThoai'],
                'tt_dh' => $row['TrangThaiDH'],
                'tt' => $row['ThanhToan'],
                'ngay_giao' => $row['NgayGH']
            );
        }
        $i=0;
    ?>
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
                            Danh sách đơn hàng
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/order/">Danh sách đơn hàng</a>
                        </div>
                    </div>
                    <div class="order_list">
                        <div class="order_list--header">
                            <a href="/../Amazing-PHP/admin/order/add/" class="btn btn-primary">Thêm đơn hàng</a>
                        </div>
                        <div style="display:flex;column-gap: 10px;margin-bottom: 10px;">
                            <div class="card cart_sum_order">
                                <div class="card-header bg-secondary btn_refresh_sum_order refresh_wait text-white"><i class="fas fa-sync-alt"></i> Chờ xác nhận <i class="fas fa-pen-square"></i></div>
                                <div class="card-body sum_order sum_order_wait"></div>
                            </div>
                            <div class="card cart_sum_order">
                                <div class="card-header bg-warning btn_refresh_sum_order refresh_process"><i class="fas fa-sync-alt"></i> Đang xử lý <i class="fas fa-recycle"></i></div>
                                <div class="card-body sum_order sum_order_process"></div>
                            </div>
                            <div class="card cart_sum_order">
                                <div class="card-header bg-primary btn_refresh_sum_order refresh_delivery text-white"><i class="fas fa-sync-alt"></i> Đang giao <i class="fas fa-truck"></i></div>
                                <div class="card-body sum_order sum_order_delivery"></div>
                            </div>
                            <div class="card cart_sum_order">
                                <div class="card-header bg-success btn_refresh_sum_order refresh_success text-white"><i class="fas fa-sync-alt"></i> Đã giao <i class="fas fa-check"></i></div>
                                <div class="card-body sum_order sum_order_success"></div>
                            </div>
                        </div>
                       
                        <div class="order_list--content">
                           <table class="table" id="list_order">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th>Mã đơn hàng</th>
                                    <th class="text-center">Giá trị đơn hàng</th>
                                    <th class="text-center">Ngày giao hàng</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th></th>
                                </thead>
                                <tbody id="result_order">
                                    <?php foreach($data_order as $val):?>
                                        <?php $i++;?>
                                        <tr>
                                            <td><strong><?=$i?></strong></td>
                                            <td><strong><?=$val['mdh']?></strong></td>
                                            <?php
                                                $ma_dh = $val['mdh'];
                                                $sql_select_sum = <<<EOT
                                                    SELECT SUM((SoLuong * GiaDatHang)*(1 - GiamGia)) tt FROM chitietdathang WHERE SoDonDH = '$ma_dh'; 
                                                EOT;
                                                $query_select_sum = mysqli_query($conn,$sql_select_sum);
                                                $result_sum = mysqli_fetch_array($query_select_sum,MYSQLI_ASSOC);
                                            ?>
                                            <td class="text-center money_sum"><?=number_format($result_sum['tt'],0,',','.')?>đ</td>
                                            <td class="text-center order_day">
                                                <?=date('d-m-Y',strtotime($val['ngay_giao']));?>
                                            </td>
                                            <td id="<?=$val["mdh"]?>">
                                                <?php if($val['tt'] == 0):?>
                                                    <span class="pay-item paying">Chưa thanh toán </span>
                                                <?php else:?>
                                                    <span class="pay-item paymented">Đã thanh toán <i class="fas fa-check"></i></span>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <?php if($val['tt_dh'] == 0):?>
                                                    <span class="btn btn-secondary btn-sm btn_wait" data-order_id="<?=$val['mdh']?>" data-val="0">Đang chờ xác nhận <i class="fas fa-pen-square"></i></span>
                                                <?php else:?>
                                                    <?php if($val['tt_dh'] == 1):?>
                                                        <span class="btn btn-warning btn-sm btn_process" data-order_id="<?=$val['mdh']?>" data-val="1">Đang xử lí <i class="fas fa-recycle"></i></span>
                                                    <?php else:?>
                                                        <?php if($val['tt_dh'] == 2):?>
                                                            <span class="btn btn-primary btn_delivery btn-sm"  data-order_id="<?=$val['mdh']?>" data-val="2">Đang giao hàng <i class="fas fa-truck"></i></span>
                                                        <?php else:?>
                                                            <span class="btn btn-success btn-sm">Đã hoàn thành <i class="fas fa-check"></i></span>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </td>
                                            <td class="text-right">
                                                <!-- <?php if($val['tt_dh'] == 0 || $val['tt_dh'] == 1):?>
                                                    <span class="btn btn-danger btn-sm cancel" data-order_id="<?=$val['mdh']?>">Hủy</span>
                                                <?php endif;?> -->
                                                <span class="btn btn-info btn-sm btn_detaile_order" data-order_id="<?=$val['mdh']?>">Chi tiết</span>
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
            <div id="order_item_show"></div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/select2/select2.min.js"></script>
    <link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/select2/select2.css">
    <script src="/../Amazing-PHP/admin/order/order_list.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>

    <script>
        $(document).ready(function(){
            $("#list_order").DataTable();
        });
    </script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>