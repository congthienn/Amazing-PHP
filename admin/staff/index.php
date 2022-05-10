<?php
    if(session_id() === ""){
        session_start();
    }
?>
<?php if(isset($_SESSION["staff"])):?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazing | Staff</title>
    <link rel='shortcut icon' href='/../Amazing-PHP/assets/uploads/tải xuống.png'/>
    <link rel="stylesheet" href="staff_list.css">
    <?php include_once __DIR__ . '/../../../Amazing-PHP/assets/vendor/library.php'?>
</head>
<body>
    <div class="main">
        <div class="row no-gutters" style="position: relative;">
            <div class="col l-2 main_slidebar">
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/slidebar.php' ?>
                </div>
            </div>
            <div class="col l-10 main_content">
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/header.php' ?>
                </div>
                <div class="item_content">
                    <div class="item_header">
                        <div class="item_title">
                            Danh sách nhân viên
                        </div>
                        <div class="item_navbar">
                            <a href="/../Amazing-PHP/admin/">Trang chủ</a> / <a href="/../Amazing-PHP/admin/staff/">Quản lí nhân viên</a>
                        </div>
                    </div>
                    <div class="staff_list">
                        <div class="staff_list--header">
                            <a href="/../Amazing-PHP/admin/staff/add/" class="btn btn-primary">Thêm nhân viên</a>
                        </div>
                        <!-- <div class="search_staff">
                            <input type="text" id="search_staff" class="form-control" placeholder="Tên nhân viên - Số điện thoại">
                        </div> -->
                        <div class="staff_list--content">
                            <?php
                                include_once __DIR__ . '/../connect_db.php';
                                $sql_select_staff = <<<EOT
                                    SELECT * FROM nhanvien nv JOIN chucvu cv ON nv.cv_id = cv.cv_id
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
                                $i=0;
                            ?>
                            <table class="table" id="list_staff">
                                <thead class="bg-dark text-white">
                                    <th>STT</th>
                                    <th width="15%">Mã nhân viên</th>
                                    <th>Nhân viên</th>
                                    <th>Địa chỉ Email</th>
                                    <th>Số điện thoại</th>
                                    <th></th>
                                </thead>
                                <tbody id="result_staff">
                                    <?php foreach($data_staff as $val):?>
                                        <?php $i++;?>
                                        <tr>
                                            <td><strong><?=$i?></strong></td>
                                            <td><strong><?=$val['msnv']?></strong></td>
                                            <td>
                                                <strong><?=$val['hoten']?></strong></br>
                                                <span class="staff_position"><?=$val['chucvu']?></span>
                                            </td>
                                            <td><span class="staff_email"><?=$val['email']?></span></td>
                                            <td><span class="staff_number"><?=$val['sodienthoai']?></span></td>
                                            <td>
                                                <?php if($val["msnv"] != "NV000001"):?>
                                                    <div class="action">
                                                        <a href="/../Amazing-PHP/admin/staff/edit/?staff_id=<?=$val['msnv']?>" class="btn btn-secondary btn-sm">Chỉnh sửa</a>
                                                        <span class="btn btn-danger btn-sm btn_delete" data-staff_id="<?=$val['msnv']?>">Xóa</span>
                                                    </div>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
                <div>
                    <?php include_once __DIR__ . '/../layouts/partials/footer.php' ?>
                </div>
            </div>
         <div id="product_show"></div>
        </div>
    </div>
    <script src="/../Amazing-PHP/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="/../Amazing-PHP/assets/vendor/jquery.min.js"></script>
    <script src="/../Amazing-PHP/admin/staff/delete_staff.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.5/datatables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#list_staff").DataTable();
        });
    </script>
</body>
</html>
<?php else: ?>
    <script>
        location.replace("/../../../Amazing-PHP/admin/login");
    </script>
<?php endif; ?>