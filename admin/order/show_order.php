<?php
    include_once __DIR__ . '/../connect_db.php';
    $order_id = $_GET['order_id'];
    $sql_select_order = <<<EOT
        SELECT dh.NgayDH,dh.NgayGH,dh.SoDonDH,dh.ThanhToan,dh.HinhThucNhanHang,dh.DiaChiNhanHang,dh.TrangThaiDH,
        kh.HoTenKH,kh.SoDienThoai,nv.HoTenNV
        FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH
        JOIN nhanvien nv ON dh.MSNV = nv.MSNV WHERE SoDonDH = '$order_id';
    EOT;
    $query_select_order = mysqli_query($conn,$sql_select_order);
    $result_order = mysqli_fetch_array($query_select_order,MYSQLI_ASSOC);
    $sql_select_product_order = <<<EOT
        SELECT * FROM chitietdathang ctdh JOIN hanghoa hh ON ctdh.MSHH = hh.MSHH WHERE SoDonDH = '$order_id';
    EOT;
    $query_select_product = mysqli_query($conn,$sql_select_product_order);
    $data_product = [];
    while($row = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC)){
        $data_product[] = array(
            'quantity' => $row['SoLuong'],
            'product_name' => $row['TenHH'],
            'product_price' => $row['Gia'],
            'product_img' => $row['HinhDaiDien'],
            'sale' => $row['GiamGia']
        );
    }
    $result = '';
    $result .='
    <div class="order_container"></div>
    <div class="order_content">
        <div class="order_header">
            Thông tin chi tiết đơn hàng
        </div>
        <div class="order_information">
            <div class="order_id order_information--item">
                Đơn hàng '.$result_order['SoDonDH'].'
            </div>
            <div class="staff_add order_information--item">
                <span class="title_order">Nhân viên tạo đơn hàng:</span> <span class="staff_name"><strong>'.$result_order['HoTenNV'].'</strong></span>
            </div>
            <div class="paymented_order order_information--item">
                <span class="title_order">Thanh toán:</span>';
                if($result_order['ThanhToan']==0){
                    $result .='<span class="pay-item paying"> Chưa thanh toán</span>';
                }else{
                    $result .='<span class="pay-item paymented"> Đã thanh toán <i class="fas fa-check"></i></span>';
                }
                 
            $result .='</div>
            <div class="order_status order_information--item">
                <span class="title_order">Trạng thái đơn hàng:</span>';
            if($result_order['TrangThaiDH'] == 0){
                $result .= '<span class="btn btn-secondary btn-sm">Đang chờ xác nhận <i class="fas fa-pen-square"></i></span>';
            }else if($result_order['TrangThaiDH'] == 1){
                $result .= '<span class="btn btn-warning btn-sm">Đang xử lí <i class="fas fa-recycle"></i></span>';
            }else if($result_order['TrangThaiDH'] == 2){
                $result .= '<span class="btn btn-primary btn-sm">Đang giao hàng <i class="fas fa-truck"></i></span>';
            }else{
                $result .= ' <span class="btn btn-success btn-sm">Đã hoàn thành <i class="fas fa-check"></i></span>';
            }
            $result .='</div>
            <div class="day_add order_information--item">
                <span class="title_order">Ngày tạo đơn hàng:</span> <span >'.date('H:i:s d-m-Y',strtotime($result_order['NgayDH'])).'</span>
            </div>
            <div class="order_information--item">
                <span class="title_order">Ngày giao hàng:</span> <span class="order_day">'.date('d-m-Y',strtotime($result_order['NgayGH'])).'</span>
            </div>
            
            <div class="product_detail order_information--item">
                <table class="table">
                    <thead class="bg-light">
                        <th width="4%">STT</th>
                        <th>Sản phẩm</th>
                        <th class="text-center">Giá bán</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Giảm giá</th>
                        <th class="text-center">Tạm tính</th>
                    </thead>
                    <tbody>';
            $i=0;
            $sum_quantity =0;
            $sum_price =0;
            foreach($data_product as $val){
                $i++;
                $sum_quantity = $sum_quantity + $val['quantity'];
                $sum_price = $sum_price + $val['product_price'];
                $result .= '
                <tr>
                    <td><strong>'.$i.'</strong></td>
                    <td>
                        <div><span class="title_order">'.$val['product_name'].'</span></div>
                    </td>
                    <td class="text-center">'.number_format($val['product_price'],0,',','.').'đ</td>
                    <td class="text-center">'.$val['quantity'].' sản phẩm</td>
                    <td class="text-center">'.$val['sale'].'</td>
                    <td class="text-center">'.number_format(($val['quantity']*$val['product_price']),0,',','.').'đ</td>
                </tr>';
            }
                        
            $result .='<tr>
                            <td colspan="3"><strong>Tổng cộng</strong></td>
                            <td class="text-center money_sum">'.$sum_quantity.' sản phẩm</td>
                            <td></td>
                            <td class="text-center money_sum">'.number_format($sum_price,0,',','.').'đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="customer_informatio order_information--item">
                <span class="title_order">Khách hàng:</span> <span class="staff_name"><strong>'.$result_order['HoTenKH'].'</strong></span>
            </div>
            <div class="customer_phone order_information--item">
                <span class="title_order">Số điện thoại:</span> '.$result_order['SoDienThoai'].'
            </div>
            <div class="location order_information--item">
                <span class="title_order">Địa chỉ nhận hàng:</span> '.$result_order['DiaChiNhanHang'].'
            </div>
            <div class="order_sale">
                <div class="title_order">Ưu đãi giành cho đơn hàng:</div>
                <div> Tặng Phiếu mua hàng Gia dụng trị giá 300.000đ</div>
                <div> Tặng Phiếu mua hàng 200.000đ áp dụng mua thẻ cào, thẻ game</div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".order_container").click(function(){
                $("#order_item_show").removeClass("show");
            });
        });
    </script>
    ';
    echo json_encode($result);
?>