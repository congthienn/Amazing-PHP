<?php
    include_once __DIR__ . '/../../connect_db.php';
    $district_id = $_GET['district_id'];
    $sql_select_ward = <<<EOT
        SELECT * FROM vn_xa_phuong WHERE districtid = '$district_id';
    EOT;
    $query_ward = mysqli_query($conn,$sql_select_ward);
    $data_ward  = [];
    while($row = mysqli_fetch_array($query_ward,MYSQLI_ASSOC)){
        $data_ward[] = array(
            'ward_id' => $row['wardid'],
            'ward_name' => $row['name']
        );
    }
    $result = '<option value="">Xã / Phường *</option>';
    foreach($data_ward as $val_ward){
        $result .= '<option value="'.$val_ward['ward_id'].'">'.$val_ward['ward_name'].'</option>';
    }
    echo json_encode($result);
?>