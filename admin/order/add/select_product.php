<?php
    include_once __DIR__ . '/../../connect_db.php';
    $category_id = $_GET['category_id'];
    $sql_select_category = <<<EOT
        SELECT * FROM loaihanghoa WHERE STT = '$category_id' OR Parent = '$category_id';
    EOT;
    $query_select_category = mysqli_query($conn,$sql_select_category);
    $data_category= [];
    while($result_category = mysqli_fetch_array($query_select_category,MYSQLI_ASSOC)){
        $data_category[] = array(
            'mlhh' => $result_category['MaLoaiHang']
        );
    }
    $data_product = [];
    foreach($data_category as $val_category){
        $mlhh = $val_category['mlhh'];
        $sql_select_product = <<<EOT
            SELECT * FROM hanghoa WHERE MaLoaiHang = '$mlhh';
        EOT;
        $quey_select_product = mysqli_query($conn,$sql_select_product);
        while($result_product = mysqli_fetch_array($quey_select_product,MYSQLI_ASSOC)){
            $data_product[] = array(
                'mshh' => $result_product['MSHH'],
                'tenhh' => $result_product['TenHH'],
                'gia' => $result_product['Gia'],
                'hinhanh' => $result_product['HinhDaiDien']
            );
        }
    }
    $result = '<option value="" data-product_price="">Chọn sản phẩm</option>';
    foreach($data_product as $val_product){
        $result .='<option value="'.$val_product['mshh'].'" data-product_price="'.$val_product['gia'].'" data-product_img="'.$val_product['hinhanh'].'">'.$val_product['tenhh'].'</option>';
    }
    echo json_encode($result);
?>