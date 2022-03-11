<?php
    include_once __DIR__ . '/../../connect_db.php';
    $province_id = $_GET['province_id'];
    $sql_select_district = <<<EOT
        SELECT * FROM vn_quan_huyen WHERE provinceid = '$province_id';
    EOT;
    $query_select = mysqli_query($conn,$sql_select_district);
    $data_district =[];
    while($row = mysqli_fetch_array($query_select,MYSQLI_ASSOC)){
        $data_district[] = array(
            'district_id' => $row['districtid'],
            'district_name' => $row['name']
        );
    }
    $result = '<option value="">Quận / Huyện</option>';
    foreach($data_district as $val_district){
        $result .= '<option value="'.$val_district['district_id'].'">'.$val_district['district_name'].'</option>';
    }
    echo json_encode($result);
?>