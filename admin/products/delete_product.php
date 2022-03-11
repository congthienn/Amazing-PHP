<?php
    include_once __DIR__ . '/../connect_db.php';
    function rmdir_recurse($path) {
        $path = rtrim($path, '/') . '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
        if($file != '.' and $file != '..' ) {
        $fullpath = $path.$file;
        if (is_dir($fullpath)) rmdir_recurse($fullpath);
        else unlink($fullpath);
        }
        }
        closedir($handle);
        rmdir($path);
    }
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];
    $delete_dir = __DIR__ . '/../../assets/uploads/products/'.$product_name;
    $sql_delete_product = <<<EOT
        DELETE FROM hanghoa WHERE MSHH = '$product_id';
    EOT;
    $sql_select_dh = <<<EOT
        SELECT * FROM chitietdathang WHERE MSHH = '$product_id'
    EOT;
    $query_select_dh = mysqli_query($conn,$sql_select_dh);
    $row = mysqli_fetch_array($query_select_dh,MYSQLI_ASSOC);
    if($row == 0){
        $sql_delete_imgs = <<<EOT
            DELETE FROM hinhhanghoa WHERE MSHH = '$product_id';
        EOT;
        mysqli_query($conn,$sql_delete_imgs);
        mysqli_query($conn,$sql_delete_product);
        rmdir_recurse($delete_dir);
        echo json_encode(1);
    }else{
        echo json_encode(0);
    }
    
?>