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
    <title>Amazing | Trang Admin</title>
    <?php include_once __DIR__ . '/../../Amazing-PHP/assets/vendor/library.php'?>
    <script src="/../Amazing-PHP/assets/vendor/chart.min.js"></script>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="report.css">
</head>
<body>
    <div class="main">
        <div class="row no-gutters">
            <div class="col l-2 main_slidebar">
                <div>
                    <?php include_once __DIR__ . '/layouts/partials/slidebar.php' ?>
                </div>
            </div>
            <div class="col l-10 main_content">
                <div>
                    <?php include_once __DIR__ . '/layouts/partials/header.php' ?>
                </div>
                <div class="item_content">
                    <div class="item_header">
                        <div class="item_title">Số liệu báo cáo thống kê Amazing</div>
                    </div>
                    <div class="report_content">
                        <div style="display: flex;justify-content: space-between;">
                            <div>
                                <div class="card cart_sum_product">
                                    <div class="card-header bg-secondary btn_refresh btn_refresh_sum_product"><i class="fas fa-sync-alt"></i> Tổng sản phẩm</div>
                                    <div class="card-body sum_product"></div>
                                </div>
                                <div style="display: flex;margin-top: 15px;">
                                    <div class="card cart_sum_revenue">
                                        <?php
                                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                                            $date_now = getdate();
                                            $month = $date_now['mon'];
                                        ?>
                                        <div class="card-header bg-success btn_refresh btn_refresh_sum_revenue"><i class="fas fa-sync-alt"></i> Doanh thu tháng <?=$month?></div>
                                        <div class="card-body sum_revenue"></div>
                                    </div>
                                    <div class="card cart_sum_order">
                                        <div class="card-header bg-primary btn_refresh btn_refresh_sum_order"><i class="fas fa-sync-alt"></i> Đơn hàng tháng <?=$month?></div>
                                        <div class="card-body sum_order"></div>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 500px;">
                                <canvas id="don_hang" height="180"></canvas>
                            </div>
                        </div>
                        
                        <div>
                            <canvas id="doanh_thu" height="200"></canvas>
                        </div>
                        <div>
                            <canvas id="san_pham" height="100"></canvas>
                        </div>
                       
                    </div>
                </div>
                <div>
                    <?php include_once __DIR__ . '/layouts/partials/footer.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/../Amazing-PHP/admin/index.js"></script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>