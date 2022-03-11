<?php
    include_once __DIR__ . '/../connect_db.php';
    $sql_select_category = <<<EOT
        SELECT * FROM loaihanghoa
    EOT;
    $query = mysqli_query($conn,$sql_select_category);
    $data=[];
    $parent_id = $_GET['Parent_id'];
    while($result = mysqli_fetch_array($query,MYSQLI_ASSOC)){
        $data[] = array(
            'stt' => $result['STT'],
            'tenloaihang' => $result['TenLoaiHang'],
            'maloaihang' => $result['MaLoaiHang'],
            'parent' => $result['Parent']
        );
    }
    $option='<option value="">Chọn danh mục loại hàng hóa</option>';
    function recursive_category($parent_id,$category_id,$string,$data){
        foreach($data as $val){
            if($category_id == $val['parent']){
                if($parent_id != 0 && $parent_id == $val['stt']){
                    $GLOBALS['option'] .= '<option selected value="'.$val['stt'].'">'.$string.''.$val['tenloaihang'].'</option>';
                }else{
                    $GLOBALS['option'] .= '<option value="'.$val['stt'].'">'.$string.''.$val['tenloaihang'].'</option>';
                }
                recursive_category($parent_id,$val['stt'],$string.'---',$data);  
            }
        }
        return $GLOBALS['option'];
    }
    $result = recursive_category($parent_id,0,'',$data);
    echo ($result);
?>