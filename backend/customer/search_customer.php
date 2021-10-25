<?php
    include_once __DIR__ . '/../connect_db.php';
    function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $key = strtolower(input_data($_GET['key']));
    if(!empty($key)){
        $sql_select_customer = <<<EOT
            SELECT * FROM khachhang 
        EOT;
        $query_select = mysqli_query($conn,$sql_select_customer);
        $data_customer =[];
        while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
            $customer_name = strtolower($result['HoTenKH']);
            $customer_phone = strtolower($result['SoDienThoai']);
            if(is_numeric(strpos($customer_name,$key))|| is_numeric(strpos($customer_phone,$key))){
                $data_customer[] = array(
                    'mskh' => $result['MSKH'],
                    'hoten' => $result['HoTenKH'],
                    'sodienthoai' => $result['SoDienThoai'],
                    'email' => $result['EmailKH'],
                    'congty' => $result['TenCongTy'],
                    'sofax' => $result['SoFax']
                );
            }
        }
    }else{
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
    }
    
    $result_customer = '';
    if(empty($data_customer)){
        $result_customer .='
        <tr class="error_search">
            <td colspan="5"> <span><i class="fas fa-search"></i> Không tìm thấy khách hàng phù hợp </span></td>
        </tr>';
        echo json_encode($result_customer);
    }else{
        $i=0;
        foreach($data_customer as $val){
            $i++;
            $result_customer .='
            <tr>
                <td><strong>'.$i.'</strong></td>
                <td><strong>'.$val['mskh'].'</strong></td>
                <td>
                    <strong>'.$val['hoten'].'</strong></br>';
                    if(!empty($val['congty'])):
                        $result_customer .='<div class="company">'.$val['congty'].'</div>';
                    endif;
                    if(!empty($val['sofax'])):
                        $result_customer .='<div class="company">Số Fax: '.$val['sofax'].'</div>';
                    endif;
                $result_customer .='
                    </td>
                    <td><span class="customer_email">'.$val['email'].'</span></td>
                    <td><span class="customer_number">'.$val['sodienthoai'].'</span></td>
                    <td>
                        <div class="action">
                            <a href="/../Amazing-PHP/backend/customer/edit/?customer_id='.$val['mskh'].'" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                        </div>
                    </td>
                </tr>';
        }
        echo json_encode($result_customer);
    }
?>