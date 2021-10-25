<?php
    include_once __DIR__ . '/../connect_db.php';
    function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $key = strtolower(input_data($_GET['search']));
    if(!empty($key)){
        $sql_select_category = <<<EOT
            SELECT * FROM loaihanghoa
        EOT;
        $query_select = mysqli_query($conn,$sql_select_category);
        $data_search = [];
        while( $result_category = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
            $category_name = strtolower($result_category['TenLoaiHang']);
            if(is_numeric(strpos($category_name,$key))){
                $data_search [] =array(
                    'maloaihang' => $result_category['MaLoaiHang'],
                    'tenloaihang' => $result_category['TenLoaiHang'],
                    'parent' => $result_category['Parent'],
                    'stt' => $result_category['STT']
                );
            }
        }
    }else{
        $sql_sum_count = <<<EOT
            SELECT COUNT(*) tonglhh FROM loaihanghoa
        EOT;
        $query_sum_count = mysqli_query($conn,$sql_sum_count);
        $result_sum_count = mysqli_fetch_array($query_sum_count,MYSQLI_ASSOC);
        $TOTAL_COUNT = $result_sum_count['tonglhh'];
        $ROW_PAGE = 6;
        $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
        $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
        $OFFSET = ($PAGE - 1) * $ROW_PAGE;
        $sql_select_category = <<<EOT
            SELECT * FROM loaihanghoa LIMIT $OFFSET,$ROW_PAGE
        EOT;
        $query_select = mysqli_query($conn,$sql_select_category);
        while($result = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
            $data_search[]= array(
                'maloaihang' => $result['MaLoaiHang'],
                'tenloaihang' => $result['TenLoaiHang'],
                'parent' => $result['Parent'],
                'stt' => $result['STT']
            );
        }
    }
    $result_search = '';
    if(empty($data_search)){
       $result_search .= '
        <tr class="error_search">
            <td colspan="4"> <span><i class="fas fa-search"></i> Không tìm thấy danh mục phù hợp </span></td>
        </tr>';
        echo json_encode($result_search);
    }else{
        $i =0;
        foreach($data_search as $val){
            $i++;
            $result_search .='
                <tr class="parent_'.$val['parent'].'">
                    <td><strong>'.$i.'</strong></td>
                    <td><div class="category_id">'.$val['maloaihang'].'</div></td>
                    <td class="category_name">'.$val['tenloaihang'].'</td>
                    <td>
                        <span class="btn btn-danger action btn-sm btn-delete" data-id="'.$val['maloaihang'].'" data-stt="parent_'.$val['stt'].'">Xóa</span>
                        <a href="/../Amazing-PHP/backend/categories/edit/?maloaihanghoa='.$val['maloaihang'].'" class="btn btn-secondary action btn-sm" style="margin-right: 5px;">Chỉnh sửa</a>
                    </td>
                </tr>';
        }
        $result_search .= ' <script src="/../Amazing-PHP/backend/categories/list_category.js"></script>';
        echo json_encode($result_search);
    }
    
?>
