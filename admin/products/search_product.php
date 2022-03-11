<?php
    include_once __DIR__ . '/../connect_db.php';
    function input_data($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }
    $text = $_GET['text'];
    $data_product = [];
        $key = strtolower(input_data($_GET['key']));
        if(!empty($key) && $text == 1){
            $sql_select_product = <<<EOT
                SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
                ON hh.MaLoaiHang = lhh.MaLoaiHang
            EOT;
            $query_product = mysqli_query($conn,$sql_select_product);
            while($result_product = mysqli_fetch_array($query_product,MYSQLI_ASSOC)){
                $product_name = strtolower($result_product['TenHH']);
                $product_id = strtolower($result_product['MSHH']);
                if(is_numeric(strpos($product_name,$key))|| is_numeric(strpos($product_id,$key))){
                    $data_product[] =array(
                        'mshh' => $result_product['MSHH'],
                        'tenhh' => $result_product['TenHH'],
                        'gia' => $result_product['Gia'],
                        'soluong' => $result_product['SoLuongHang'],
                        'hinhanh' => $result_product['HinhDaiDien'],
                        'tenloaihang' => $result_product['TenLoaiHang']
                    );
                }
            }
        }else if(!empty($key) && $text == 0){
            $sql_select_product = <<<EOT
                SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
                ON hh.MaLoaiHang = lhh.MaLoaiHang WHERE lhh.STT = '$key' OR lhh.Parent = '$key'
            EOT;
            $query_product = mysqli_query($conn,$sql_select_product);
            while($result_product = mysqli_fetch_array($query_product,MYSQLI_ASSOC)){
                $data_product[] =array(
                    'mshh' => $result_product['MSHH'],
                    'tenhh' => $result_product['TenHH'],
                    'gia' => $result_product['Gia'],
                    'soluong' => $result_product['SoLuongHang'],
                    'hinhanh' => $result_product['HinhDaiDien'],
                    'tenloaihang' => $result_product['TenLoaiHang']
                );
            }
        }
        else{
            $sql_sum = <<<EOT
                SELECT COUNT(*) tonghh FROM hanghoa
            EOT;
            $query_sum = mysqli_query($conn,$sql_sum);
            $result_sum = mysqli_fetch_array($query_sum,MYSQLI_ASSOC);
            $TOTAL_COUNT = $result_sum['tonghh'];
            $ROW_PAGE = 4;
            $TOTAL_PAGE = ceil($TOTAL_COUNT / $ROW_PAGE);
            $PAGE = isset($_GET['page']) ? $_GET['page'] : 1;
            $OFFSET = ($PAGE - 1)*$ROW_PAGE;
            //Select product
            $sql_select_product = <<<EOT
                SELECT * FROM hanghoa hh JOIN loaihanghoa lhh
                ON hh.MaLoaiHang = lhh.MaLoaiHang LIMIT $OFFSET,$ROW_PAGE;
            EOT;
            $query = mysqli_query($conn,$sql_select_product);
            $data_product = [];
            while($result = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                $data_product[] =array(
                    'mshh' => $result['MSHH'],
                    'tenhh' => $result['TenHH'],
                    'gia' => $result['Gia'],
                    'soluong' => $result['SoLuongHang'],
                    'hinhanh' => $result['HinhDaiDien'],
                    'tenloaihang' => $result['TenLoaiHang']
                );
            }
        }
        
    $result_search ='';
    if(empty($data_product)){
        $result_search .='
        <tr class="error_search">
            <td colspan="5"> <span><i class="fas fa-search"></i> Không tìm thấy sản phẩm phù hợp </span></td>
        </tr>';
        echo json_encode($result_search);
    }else{
        $i =0;
        foreach($data_product as $val){
            $i++;
            $result_search .='
            <tr>
                <td><strong>'.$i.'</strong></td>
                <td class="product_img_name">
                    <div><img src="/../Amazing-PHP/assets/uploads/products/'.$val['tenhh'].'/'.$val['hinhanh'].'" alt="" width="65px"></div>
                    <div style="margin-left: 10px;">
                        <div class="product_name">'.$val['tenhh'].'</div>
                        <div style="font-style: italic;">'.$val['tenloaihang'].'</div>
                    </div>
                
                </td>
                <td><strong>'.$val['mshh'].'</strong></td>
                <td class="product_price">'.number_format($val['gia'],0,',','.').'đ</td>
                <td class="product_quantity">'.$val['soluong'].' sản phẩm</td>
                <td>
                    <div class="action">
                        <span class="btn btn-info btn-sm btn_show" data-product_id="'.$val['mshh'].'">Chi tiết</span>
                        <a href="/../Amazing-PHP/admin/products/edit/?product_id='.$val['mshh'].'" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                        <span class="btn btn-danger btn-sm btn-delete" data-product_id="'.$val['mshh'].'" data-product_name="'.$val['tenhh'].'">Xóa</span>
                    </div>
                </td>
            </tr>
            ';
        }
        $result_search .=' <script src="/../Amazing-PHP/admin/products/product_list.js"></script>';
        echo json_encode($result_search);
    }
?>