<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Order</title>
    <link rel="stylesheet" href="order_list.css">
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
    <?php
        include_once __DIR__ . '/../connect_db.php';
        $sql_sum_count = <<<EOT
            SELECT COUNT(*) tongdh FROM dathang
        EOT;
        $query_sum_count = mysqli_query($conn,$sql_sum_count);
        $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
        $TOTAL_COUNT = $result_sum_count['tongdh'];
        $ROW_PAGE = 6;
        $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
        $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
        $OFFSET = ($PAGE - 1) * $ROW_PAGE;
        $sql_select_order  = <<<EOT
            SELECT * FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH ORDER BY dh.TrangThaiDH ASC LIMIT $OFFSET,$ROW_PAGE
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
                            <a href="/../Amazing-PHP/backend/">Trang chủ</a> / <a href="/../Amazing-PHP/backend/order/">Danh sách đơn hàng</a>
                        </div>
                    </div>
                    <div class="order_list">
                        <div class="order_list--header">
                            <a href="/../Amazing-PHP/backend/order/add/" class="btn btn-primary">Thêm đơn hàng</a>
                        </div>
                        <div class="search_order">
                            <select name="" id="order_status">
                                <option value="">Trạng thái đơn hàng</option>
                                <option value="0">Đang chờ xác nhận <i class="fas fa-pen-square"></i></option>
                                <option value="1">Đang xử lí <i class="fas fa-recycle"></option>
                                <option value="2">Đang giao hàng <i class="fas fa-truck"></option>
                                <option value="3">Đã hoàn thành <i class="fas fa-check"></i></option>
                            </select>
                            <input type="text" id="order_id" class="form-control" placeholder="Mã đơn hàng">
                        </div>
                        <div class="order_list--content">
                           <table class="table">
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
                                            <td>
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
                                                            <span class="btn btn-primary btn-sm">Đang giao hàng <i class="fas fa-truck"></i></span>
                                                        <?php else:?>
                                                            <span class="btn btn-success btn-sm">Đã hoàn thành <i class="fas fa-check"></i></span>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </td>
                                            <td class="text-right">
                                                <?php if($val['tt_dh'] == 0 || $val['tt_dh'] == 1):?>
                                                    <span class="btn btn-danger btn-sm cancel" data-order_id="<?=$val['mdh']?>">Hủy</span>
                                                <?php endif;?>
                                                <span class="btn btn-info btn-sm btn_detaile_order" data-order_id="<?=$val['mdh']?>">Chi tiết</span>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                           </table>
                        </div>
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
            <div id="order_item_show"></div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/select2/select2.min.js"></script>
    <link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/select2/select2.css">
    <script src="/../Amazing-PHP/backend/order/order_list.js"></script>
    <script>
        $(document).ready(function(){
            $("#order_status").select2();
            $("#order_id").keyup(function(){
                $('#order_status').val('');
                $("#select2-order_status-container").text("Trạng thái đơn hàng");
                var key = $(this).val();
                var page = <?=$PAGE?>;
                var text = 1;
                $.ajax({
                    type: "GET",
                    url: "search_order.php",
                    data:{
                        key,page,text
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_order").html(response);
                    }
                });
            });
            $('#order_status').change(function(){
                var key = $(this).val();
                $("#order_id").val('');
                var text = 0;
                $.ajax({
                    type: "GET",
                    url: "search_order.php",
                    data:{
                        key,text
                    },
                    dataType: "json",
                    success: function (response) {
                        $("#result_order").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>