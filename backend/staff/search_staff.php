<?php
    include_once __DIR__ . '/../connect_db.php';
    function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $key =strtolower(input_data($_GET['key']));
    if(!empty($key)){
        $sql_select_staff = <<<EOT
            SELECT * FROM nhanvien nv JOIN chucvu cv ON nv.cv_id = cv.cv_id
        EOT;
        $query_select = mysqli_query($conn,$sql_select_staff);
        $data_staff =[];
        while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
            $staff_name = strtolower($result['HoTenNV']);
            $staff_phone = strtolower($result['SoDienThoai']);
            if(is_numeric(strpos($staff_name,$key)) || is_numeric(strpos($staff_phone,$key))){
                $data_staff[] = array(
                    'msnv' => $result['MSNV'],
                    'hoten' => $result['HoTenNV'],
                    'chucvu' => $result['cv_ten'],
                    'sodienthoai' => $result['SoDienThoai'],
                    'email' => $result['Email']
                );
            }
        }
    }else{
        $sql_sum_count = <<<EOT
            SELECT COUNT(*) tongnv FROM nhanvien
        EOT;
        $query_sum_count = mysqli_query($conn,$sql_sum_count);
        $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
        $TOTAL_COUNT = $result_sum_count['tongnv'];
        $ROW_PAGE = 5;
        $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
        $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
        $OFFSET = ($PAGE - 1) * $ROW_PAGE;
        $sql_select_staff = <<<EOT
            SELECT * FROM nhanvien nv JOIN chucvu cv ON nv.cv_id = cv.cv_id LIMIT $OFFSET,$ROW_PAGE
        EOT;
        $query_select = mysqli_query($conn,$sql_select_staff);
        $data_staff =[];
        while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
            $data_staff[] = array(
                'msnv' => $result['MSNV'],
                'hoten' => $result['HoTenNV'],
                'chucvu' => $result['cv_ten'],
                'sodienthoai' => $result['SoDienThoai'],
                'email' => $result['Email']
            );
        }
    }
    $result_staff = '';
    if(empty($data_staff)){
        $result_staff .='
        <tr class="error_search">
            <td colspan="5"> <span><i class="fas fa-search"></i> Không tìm thấy nhân viên phù hợp </span></td>
        </tr>';
        echo json_encode($result_staff);
    }else{
        $i=0;
        foreach($data_staff as $val){
            $i++;
            $result_staff .='
            <tr>
                <td><strong>'.$i.'</strong></td>
                <td><strong>'.$val['msnv'].'</strong></td>
                <td>
                    <strong>'.$val['hoten'].'</strong></br>
                    <span class="staff_position">'.$val['chucvu'].'</span>
                </td>
                <td><span class="staff_email">'.$val['email'].'</span></td>
                <td><span class="staff_number">'.$val['sodienthoai'].'</span></td>
                <td>
                    <div class="action">
                        <a href="/../Amazing-PHP/backend/staff/edit/?staff_id='.$val['msnv'].'" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                        <span class="btn btn-danger btn-sm btn_delete" data-staff_id="'.$val['msnv'].'">Xóa</span>
                    </div>
                </td>
            </tr>
            ';
        }
        $result_staff .='<script src="/../Amazing-PHP/backend/staff/delete_staff.js"></script>';
        echo json_encode($result_staff);
    }
?>