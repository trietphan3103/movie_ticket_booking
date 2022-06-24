<?php
    session_start();
    error_reporting(0);
    require_once("../../utils.php"); 
    _require_login();
    _require_not_client();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>Quản lý ghế</title>
</head>

<body>
    <?php
        require("../Common/Header.php");
        require("../../api/Ghe/GheGet.api.php");
    ?>

    <div id="lich-management-wrapper">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb mb-4 list-unstyled">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none">Trang chủ</a>
                    </li>
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Quản lý ghế</li>
                </ol>
            </div>
            <div class="add-lich-chieu__btn">
                <div class="btn_contain" href="#" data-toggle="modal" data-target="#addGheModal">
                    <label>Thêm ghế mới</label>
                    <i class="fas fa-plus-circle add_btn"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-12 lich-table">
                    <?php
                        if(isset($_GET["status"])){
                            if($_GET["status"] == "created")
                                echo '<div class="alert alert-info"> Thêm ghế thành công </div>';
                            if($_GET["status"] == "deleted")
                                echo '<div class="alert alert-info"> Xóa ghế thành công </div>';
                        }
                    ?>
                    <table class="table table-striped table-bordered table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Mã ghế</th>
                                <th scope="col">Phòng chiếu</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = _get_list_seats();
                        if ($result->num_rows > 0) {
                            while ($row =  $result->fetch_assoc()) { ?>
                                <tr>
                                    <td scope="row"><?php echo $row['ghe_id']; ?></td>
                                    <td class="ma-ghe-td"><?php echo $row['ma_ghe']; ?></td>
                                    <td><?php echo $row['ten_phong']; ?></td>
                                    <td class="lich-actions">
                                        <button class="btn btn-danger delete-ghe-btn user-delete-btn" data-toggle="modal" data-target="#delGheModal" onclick="_set_selected_ghe(<?php echo $row['ghe_id'] ?>)" value="<?php echo $row['ghe_id'] ?>">Xóa</button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <h1>Bảng chưa có dữ liệu</h1>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal thêm ghế -->
    <div class="modal fade" id="addGheModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhongChieuModalLabel">Thêm ghế mới</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form id="ghe-create-form">
                                    <div id="lich-manage-detail">
                                        <div class="form-group row">
                                            <label for="ghe-name-input" class="col-md-5 col-sm-12 col-form-label">
                                                <i class="fas fa-video mr-2"></i>Mã ghế:
                                            </label>
                                            <div class="lich-manage-detail__select col-md-7 col-sm-12">
                                                <input type="text" name="ghe-name" id="ghe-name-input" class="form-control" placeholder="Nhập mã ghế">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="select-phong-existed" class="col-md-5 col-sm-12 col-form-label">
                                                <i class="fas fa-video mr-2"></i>Phòng chiếu:
                                            </label>
                                            <div class="lich-manage-detail__select col-md-7 col-sm-12">
                                                <select class="custom-select" id="select-phong-existed">
                                                    <option selected value="">Chọn phòng chiếu...</option>
                                                    <?php 
                                                        $room_list = _get_available_room();
                                                        if ($room_list->num_rows > 0) {
                                                            while ($room =  $room_list->fetch_assoc()) {
                                                    ?>
                                                        <option class="available-room" value="<?php echo $room['phong_chieu_id'] ?>"> <?php echo $room['ten_phong'] ?> </option>
                                                    <?php
                                                        }
                                                    } 
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" id="message_create_ghe"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn lich-chieu-btn">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xóa ghế -->
    <div class="modal fade" id="delGheModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delPhongChieuModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="del-phong-title" id="ghe_delete_msg">Bạn có chắc chắn muốn xóa ghế chứ?</div>
                                <div class="alert alert-danger" role="alert" id="message_delete_ghe"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn lich-chieu-btn" id="ghe-delete-confirm-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include("../Common/Footer.php");
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>