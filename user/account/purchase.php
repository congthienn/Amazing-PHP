<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(!isset($_SESSION["email"])):?>
    <script>location.replace("/../Amazing-PHP/user/")</script>
<?php else:?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Thông tin tài khoản</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="account.css">
</head>
<body>
    <div id="header">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/header.php' ?>
    </div>
    <div id="main">
        <div class="container_navbar">
            <div class="grid wide">
                <div class="navbar">
                    <a href="/../Amazing-PHP/user/">Trang chủ</a> <i class="fas fa-angle-right icon_navbar"></i> <a href="/../Amazing-PHP/user/cart/">Thông tin tài khoản</a>
                </div>
            </div>
        </div>
        <div class="container_content">
            <div class="grid wide" >
                <div class="row">
                    <div class="col l-3">
                        <div>
                            <ul class="sildebar_account">
                                <li class="sildebar--item"><a href="/../Amazing-PHP/user/account/"><i class="fas fa-user"></i> Tài khoản của tôi</a></li>
                                <li class="sildebar--item"><a href="purchase.php"><i class="far fa-file"></i> Danh sách các đơn hàng</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col l-9" >
                            <?php
                                    include_once __DIR__ . '/../../admin/connect_db.php';
                                    $email = $_SESSION['email'];
                                    $sql_select_user = <<<EOT
                                        SELECT * FROM khachhang WHERE EmailKH ="$email"
                                    EOT;
                                    $query_select_user = mysqli_query($conn,$sql_select_user);
                                    $result_user = mysqli_fetch_array($query_select_user,MYSQLI_ASSOC);
                                    $user_id = $result_user["MSKH"];
                                ?>
                        <div>
                            <div class="container_account">
                                <div class="title">
                                    Thông tin các đơn hàng của bạn
                                </div>
                            </div>
                            <?php
                                $sql_select_order = <<<EOT
                                    SELECT * FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH WHERE kh.MSKH ="$user_id" ORDER BY NgayDH DESC
                                EOT;
                                $query_select_order = mysqli_query($conn,$sql_select_order);
                                $data_order =[];
                                while($row = mysqli_fetch_array($query_select_order,MYSQLI_ASSOC)){
                                    $data_order[] = array(
                                        "SoDonDH" => $row['SoDonDH'],
                                        "NgayDH" => $row['NgayDH'],
                                        "NgayGH" => $row['NgayGH'],
                                        "DiaChi" => $row['DiaChiNhanHang'],
                                        "TrangThaiDH" => $row['TrangThaiDH'],
                                        "ThanhToan" => $row['ThanhToan']
                                    );
                                }
                            ?>
                            <?php if(empty($data_order)):?>
                                <div class="container_account">
                                    <div class="empty_order">
                                        <div style="text-align:center">
                                            <div><span  style="font-size:50px;font-weight: 600;"><i class="fas fa-shopping-cart"></i></span></div>
                                            <div><span>Bạn không có đơn hàng nào</span></div> 
                                        </div>
                                    </div>
                                </div>
                                
                            <?php else: ?>
                                <div class="container-order">
                                    <?php foreach($data_order as $value): ?>
                                        <?php
                                            $order_id = $value['SoDonDH'];
                                            $sql_select_detail_order = <<<EOT
                                                SELECT * FROM chitietdathang ctdh JOIN  hanghoa hh ON ctdh.MSHH = hh.MSHH WHERE SoDonDH = "$order_id" ;
                                            EOT;
                                            $query_select_detail_order = mysqli_query($conn,$sql_select_detail_order);
                                            $data_detail_order = [];
                                            while($row = mysqli_fetch_array($query_select_detail_order,MYSQLI_ASSOC)){
                                                $data_detail_order[] = array(
                                                    "TenHH" => $row["TenHH"],
                                                    "Gia" => $row["GiaDatHang"],
                                                    "SL" => $row["SoLuong"],
                                                    "Hinhanh" => $row["HinhDaiDien"]
                                                );
                                            }
                                        ?>
                                        <div class="container_account">
                                            <div style="display:flex;margin: 10px 0 ;justify-content: space-between;font-size: 18px;">
                                                <div>
                                                    <div>
                                                        <span class="order-id">Mã đơn hàng: <?=$value['SoDonDH'];?></span> | 
                                                        <?php if($value['ThanhToan'] == 0):?>
                                                            <span class="pay-item paying">Chưa thanh toán </span>
                                                        <?php else:?>
                                                            <span class="pay-item paymented">Đã thanh toán <i class="fas fa-check"></i></span>
                                                        <?php endif;?>
                                                    </div>
                                                    <div style="display:flex;column-gap: 60px;" class="item">
                                                        <div>Ngày đặt hàng: <?=date('H:i:s d-m-Y',strtotime($value['NgayDH']));?></div> 
                                                        <div>Ngày giao hàng: <?=date('d-m-Y',strtotime($value['NgayGH']));?></div> 
                                                    </div>
                                                    <div class="item" style="width: 700px;">
                                                        Địa chỉ nhận hàng: <?=$value["DiaChi"]?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?php if($value['TrangThaiDH'] == 0):?>
                                                        <span class="btn_status btn_wait">Đang chờ xác nhận</span>
                                                    <?php else:?>
                                                        <?php if($value['TrangThaiDH'] == 1):?>
                                                            <span class="btn_status btn_process">Đang xử lí</span>
                                                        <?php else:?>
                                                            <?php if($value['TrangThaiDH'] == 2):?>
                                                                <span class="btn_status btn btn_delivery">Đang giao hàng</span>
                                                            <?php else:?>
                                                                <span class="btn_status btn_success">Đã hoàn thành</span>
                                                            <?php endif;?>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                </div> 
                                            </div>
                                            <?php $sum_order = 0;?>
                                            <?php foreach($data_detail_order as $val):?>
                                                <div style="display:flex;column-gap: 20px;">
                                                    <div><img src="/../Amazing-PHP/assets/uploads/products/<?=$val["TenHH"]?>/<?=$val["Hinhanh"]?>" alt="" width="100px"></div>
                                                    <div style="flex:1">
                                                        <div style="font-size: 17px"><?=$val["TenHH"]?></div>
                                                        <div style="font-weight: 600;"> x<?=$val["SL"]?></div>
                                                    </div>
                                                    <div style="font-size: 17px;color: green;font-weight: 600;"><?=number_format($val["Gia"],0,",",".")?> VND</div>
                                                </div>
                                                <?php $sum_order+= $val["Gia"]?>
                                            <?php endforeach;?>
                                            <div class="sum_order">Tổng số tiền: <span class="price"><?=number_format($sum_order,0,",",".")?> VND</span></div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <?php include_once __DIR__ . '/../../../Amazing-PHP/user/layouts/partials/footer.php'?>
    </div>
    <script src="account.js"></script>
</body>
</html>
<?php endif;?>