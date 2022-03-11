<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Add Order</title>
    <link rel="stylesheet" href="order_add.css">
    <?php include_once __DIR__ . '/../../../../Amazing-PHP/assets/vendor/library.php'?>
    <?php
        include_once __DIR__ . '/../../connect_db.php';
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $sql_select_customer = <<<EOT
            SELECT * FROM khachhang 
        EOT;
        $data_customer = [];
        $query_select_customer = mysqli_query($conn,$sql_select_customer);
        while($result_customer = mysqli_fetch_array($query_select_customer,MYSQLI_ASSOC)){
            $data_customer[]=array(
                'mskh' => $result_customer['MSKH'],
                'hotenkh' => $result_customer['HoTenKH'],
                'sodienthoai' => $result_customer['SoDienThoai']
            );
        }
        $date_now = date("H:i:s d/m/y",time());
    ?>
    <?php
        $sql_select_province = <<<EOT
            SELECT * FROM vn_tinh
        EOT;
        $query_select_province = mysqli_query($conn,$sql_select_province);
        $data_province = [];
        while($result_province = mysqli_fetch_array($query_select_province,MYSQLI_ASSOC)){
            $data_province[] =array(
                'province_id' => $result_province['provinceid'],
                'province_name' => $result_province['name']
            );
        }
    ?>
    <?php
        $sql_select_product = <<<EOT
            SELECT * FROM hanghoa
        EOT;
        $query_select_product = mysqli_query($conn,$sql_select_product);
        $data_product =[];
        while($result_product = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC)){
            $data_product[] = array(
                'mshh' => $result_product['MSHH'],
                'tenhh' => $result_product['TenHH'],
                'gia' => $result_product['Gia'],
                'hinhanh' => $result_product['HinhDaiDien']
            );
        }
    ?>
</head>
<body style="position: relative;">
    <div class="main">
        <div class="row no-gutters">
            <div class="col l-2 main_slidebar">
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/slidebar.php' ?>
                </div>
            </div>
            <div class="col l-10 main_content">
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/header.php' ?>
                </div>
                <div class="item_content">
                    <div class="item_header">
                        <div class="item_title">
                            Thêm đơn hàng
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/order/">Danh sách đơn hàng</a> / Thêm đơn hàng
                        </div>
                    </div>
                    <div class="col l-12">
                        <div class="form_insert">
                           <form action="processed_add_order.php" method="POST" name="formInsertOrder" id="formInsertOrder">
                                <div style="margin: 20px 0 10px;"><strong>Thông tin sản phẩm đơn hàng</strong></div>
                                <div class="order_information">
                                    <div class="list_category">
                                        <select name="list_category" id="list_category" class="form-control"></select>
                                    </div>
                                    <div class="list_product">
                                        <select name="list_product" id="list_product" class="form-control">
                                            <option value="" data-product_price="">Chọn sản phẩm</option>
                                            <?php foreach($data_product as $val_product):?>
                                                <option value="<?=$val_product['mshh']?>" data-product_price="<?=$val_product['gia']?>" data-product_img="<?=$val_product['hinhanh']?>"><?=$val_product['tenhh']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div id="error_product_name">

                                        </div>
                                    </div>
                                    <div class="product_price">
                                        <input type="text" value="" id="product_price" class="form-control" placeholder="Giá bán" readonly>
                                    </div>
                                    <div class="quantity">
                                        <div class="form-group">
                                            <label for="product_quantity"><strong>Số lượng</strong></label>
                                            <input type="number" min="0" value="" class="form-control" id="product_quantity">
                                            <div id="error_product_quantity"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span class="btn btn-info" id="btn_insert_product" style="margin-left: 20px;">Thêm</span>
                                    </div>
                                </div>
                                <div class="list_product_order">
                                    <input type="text" value="" name="money_sum_order" id="money_sum_order" readonly>
                                    <table class="table">
                                        <thead class="bg-light">
                                            <th width="5%">STT</th>
                                            <th>Sản phẩm</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-center">Giá bán</th>
                                            <th class="text-center">Tạm tính</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="result_product_order"></tbody>
                                        <tbody>
                                            
                                        </tbody>
                                        <tr id="review_order">
                                            <td colspan="2"><strong>Tổng cộng</strong></td>
                                            <td class="text-center text-danger"><strong>0 sản phẩm</strong></td>
                                            <td></td>
                                            <td class="text-center text-danger"><strong>0</strong></td>
                                        </tr>
                                    </table>
                                    
                                </div>
                                <div class="customer_information">
                                    <div class="form-group">
                                        <label for="customer_information"><strong>Thông tin khách hàng</strong></label>
                                        <select name="customer_information" id="customer_information" class="form-control">
                                            <option value=""></option>
                                            <?php foreach($data_customer as $val):?>
                                                <option value="<?=$val['mskh']?>"><span><?=$val['hotenkh']?> - <?=$val['sodienthoai']?></span></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="customer_day_location">
                                    <div class="date_add">
                                        <div class="form-group">
                                            <span><strong>Ngày nhập đơn hàng</strong></span>
                                            <input type="text" readonly class="form-control" value="<?=$date_now?>">
                                        </div>
                                    </div>
                                    <div class="delivery_date">
                                        <div class="form-group">
                                            <label for="delivery_date"><strong>Ngày giao hàng</strong></label>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                                        </div>
                                    </div>
                                    <div class="delivery">
                                        <div class="form-group">
                                            <label for="delivery"><strong>Hình thức nhận hàng</strong></label>
                                            <div>
                                                <select name="delivery" id="delivery" class="form-control">
                                                    <option value=""></option>
                                                    <option value="1">Nhận tại cửa hàng</option>
                                                    <option value="2">Giao hàng tận nơi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment_status">
                                    <span><strong>Trạng thái thanh toán</strong></span>
                                    <div class="payment_status--radio">
                                        <div class="paymented pay--item">
                                            <label for="dathanhtoan"><span>Đã thanh toán</span></label>
                                            <input type="radio" name="pay" id="dathanhtoan" value="1">
                                        </div>
                                        <div class="unpaid pay--item">
                                            <label for="chuathanhtoan"><span>Chưa thanh toán</span></label>
                                            <input type="radio" name="pay" id="chuathanhtoan" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="location">
                                    <strong>Địa chỉ nhận hàng</strong>
                                    <div class="company_location">
                                        <input type="text" name="text_location_company" id="text_location_company" class="form-control" value="Cửa hàng Amazing - số 12 đường 30/4 - phường Xuân Khánh - quận Ninh Kiều - Thành phố Cần Thơ" readonly> 
                                    </div>
                                    <div class="location_content">
                                        <div class="location_province_district">
                                            <div class="form-group fist-item">
                                                <div>
                                                    <select name="province" id="province" class="form-control">
                                                        <option value="">Tỉnh / Thành phố</option>
                                                        <?php foreach($data_province as $val_province):?>
                                                            <option value="<?=$val_province['province_id']?>"><?=$val_province['province_name']?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <select name="district" id="district" class="form-control">
                                                        <option value="">Quận / Huyện</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="location_ward">
                                            <div class="form-group fist-item">
                                                <div>
                                                    <select name="ward" id="ward" class="form-control">
                                                        <option value="">Xã / Phường</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="stress" name="stress" placeholder="Địa chỉ nhà / Tên đường">
                                            </div>
                                        </div>
                                        <div class="text_location">
                                            <textarea type="text" class="form-control" id="text_location" name="text_location" rows="2" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="voucher">
                                    <div class="form-group">
                                        <label for="voucher"><strong>Mã giảm giá</strong></label>
                                        <input type="text" name="voucher" id="voucher" class="form-control">
                                    </div>
                                </div>
                                <div style="margin-top: 20px;">
                                    <button class="btn btn-primary" name="btn_insertOrder">Tạo đơn hàng</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
                <div>
                    <?php include_once __DIR__ . '/../../layouts/partials/footer.php' ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.validate.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/select2/select2.min.js"></script>
    <link rel="stylesheet" href="/../Amazing-PHP/assets/vendor/select2/select2.css">
    <script src="/../Amazing-PHP/admin/order/add/add_order.js"></script>
</body>
</html>