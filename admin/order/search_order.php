<?php
    include_once __DIR__ . '/../connect_db.php';
    function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $key = strtolower(input_data($_GET['key']));
    $text = $_GET['text'];
    
        if(!empty($key) && $text == 1){
            $sql_select_order  = <<<EOT
                SELECT * FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH ORDER BY dh.TrangThaiDH ASC 
            EOT;
            $query_order = mysqli_query($conn,$sql_select_order);
            $data_order =[];
            while($row = mysqli_fetch_array($query_order,MYSQLI_ASSOC)){
                $order_id = strtolower($row['SoDonDH']);
                if(is_numeric(strpos($order_id,$key))){
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
            }
        }
        else if((!empty($key) || $key ==0) && $text == 0){
            $sql_select_order  = <<<EOT
                SELECT * FROM dathang dh JOIN khachhang kh ON dh.MSKH = kh.MSKH WHERE TrangThaiDH = '$key' ORDER BY NgayDH ASC
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
        }else{
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
        }
    $result_order  = '';
    if(empty($data_order)){
        $result_order .='
        <tr class="error_search">
            <td colspan="6"> <span><i class="fas fa-search"></i> Không tìm thấy đơn hàng phù hợp </span></td>
        </tr>';
        echo json_encode($result_order);
    }else{
        $i=0;
        foreach($data_order as $val){
            $i++;
            $result_order .= '
            <tr>
                <td><strong>'.$i.'</strong></td>
                <td><strong>'.$val['mdh'].'</strong></td>';
                                           
                $ma_dh = $val['mdh'];
                $sql_select_sum = <<<EOT
                    SELECT SUM((SoLuong * GiaDatHang)*(1 - GiamGia)) tt FROM chitietdathang WHERE SoDonDH = '$ma_dh'; 
                EOT;
                $query_select_sum = mysqli_query($conn,$sql_select_sum);
                $result_sum = mysqli_fetch_array($query_select_sum,MYSQLI_ASSOC);
                                          
            $result_order .='<td class="text-center money_sum">'.number_format($result_sum['tt'],0,',','.').'đ</td>
                                <td class="text-center order_day">
                                    '.date('d-m-Y',strtotime($val['ngay_giao'])).'
                                </td>
                            <td>';
                        if($val['tt'] == 0):
                            $result_order .=' <span class="pay-item paying">Chưa thanh toán </span>';
                        else:
                            $result_order .='<span class="pay-item paymented">Đã thanh toán <i class="fas fa-check"></i></span>';
                        endif;
                           $result_order .=' </td>
                                            <td>';
                        if($val['tt_dh'] == 0):
                            $result_order .='<span class="btn btn-secondary btn-sm btn_wait" data-order_id="'.$val['mdh'].'" data-val="0">Đang chờ xác nhận <i class="fas fa-pen-square"></i></span>';
                        else:
                            if($val['tt_dh'] == 1):
                                $result_order .='<span class="btn btn-warning btn-sm btn_process" data-order_id="'.$val['mdh'].'" data-val="1">Đang xử lí <i class="fas fa-recycle"></i></span>';
                            else:
                                if($val['tt_dh'] == 2):
                                    $result_order .='<span class="btn btn-primary btn-sm">Đang giao hàng <i class="fas fa-truck"></i></span>';
                                else:
                                    $result_order .='<span class="btn btn-success btn-sm">Đã hoàn thành <i class="fas fa-check"></i></span>';
                                endif;
                            endif;
                        endif;
                        $result_order .='
                                </td>
                                <td class="text-right">';
                                 
                                if($val['tt_dh'] == 0 || $val['tt_dh'] == 1):
                                    $result_order .='<span class="btn btn-danger btn-sm cancel" data-order_id="'.$val['mdh'].'">Hủy</span>';
                                endif;
                        $result_order .='  <span class="btn btn-info btn-sm btn_detaile_order" data-order_id="'.$val['mdh'].'">Chi tiết</span>
                                            </td>
                                        </tr>';
        }
        $result_order .='<script src="/../Amazing-PHP/admin/order/order_list.js"></script>';
        echo json_encode($result_order);
    }
?>