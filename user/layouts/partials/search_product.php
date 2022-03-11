<?php

use function PHPSTORM_META\elementType;

include_once __DIR__ . '/../../../../Amazing-PHP/admin/connect_db.php';
    function inputdata($data){
        $data = trim($data);
        return $data;
    }
    $key = inputdata($_GET['key']);
    $sql_select_product = <<<EOT
        SELECT * FROM hanghoa
    EOT;
    $query_select_product = mysqli_query($conn,$sql_select_product);
    $data_product = [];
    while($result = mysqli_fetch_array($query_select_product,MYSQLI_ASSOC)){
        $product_name = strtolower($result['TenHH']);
        $key = strtolower($key);
        if(is_numeric(strpos($product_name,$key))){
            $data_product[] = array(
                'product_name' => $result['TenHH'],
                'product_id' => $result['MSHH'],
                'product_price' => $result['Gia'],
                'product_img' => $result['HinhDaiDien']
            );
        }
    }
    if(empty($key)){
        echo json_encode("");
    }else if(!empty($data_product)){
        $result_json='
            <div class="container_search_product">
                <div class="search_product--heaeder">
                    Sản phẩm gợi ý cho bạn
                </div>
                <div class="search_product--content">
            ';
            foreach($data_product as $val){
                $result_json .='
                <div>
                    <a class="search_product--item" href="/../../../../Amazing-PHP/user/product/?product='.$val['product_id'].'">
                        <img src="/../Amazing-PHP/assets/uploads/products/'.$val['product_name'].'/'.$val['product_img'].'" width="90px">
                        <div class="search_product--name&price">
                            <div class="search_product--name">'.$val['product_name'].'</div>
                            <div class="search_product--price">'.number_format($val['product_price'],0,',','.').'đ</div>
                            <div class="search_product--star">';
                                for($i=0;$i<5;$i++):
                            $result_json.= '<i class="far fa-star icon_star"></i>';
                                endfor;
                    $result_json .='
                            </div>
                        </div>
                    </a>
                </div>';
            }
            $result_json .='
                </div>
            </div>';
        echo  json_encode($result_json);
    }else{
        $result_json = '
        <div class="container_search_product">
            <div class="search_no"><span><i class="fas fa-search"></i> Không tìm thấy sản phẩm phù hợp</div></span>
        </div>';
        echo json_encode($result_json);
    }
?>