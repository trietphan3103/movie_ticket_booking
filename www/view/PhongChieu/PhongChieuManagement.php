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
    <title>Quản lý phòng chiếu</title>
</head>

<body>
    <?php
        require("../Common/Header.php");
        require("../../api/PhongChieu/PhongChieuGet.api.php");
    ?>

    <div id="lich-management-wrapper">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb mb-4 list-unstyled">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none">Trang chủ</a>
                    </li>
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Quản lý phòng chiếu</li>
                </ol>
            </div>
            <div class="add-lich-chieu__btn">
                <div class="btn_contain" href="#" data-toggle="modal" data-target="#addPhongChieuModal">
                    <label>Thêm phòng chiếu</label>
                    <i class="fas fa-plus-circle add_btn"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-12 lich-table">
                    <?php
                        if(isset($_GET["status"])){
                            if($_GET["status"] == "created")
                                echo '<div class="alert alert-info"> Thêm lịch chiếu thành công </div>';
                            if($_GET["status"] == "deleted")
                                echo '<div class="alert alert-info"> Xóa lịch chiếu thành công </div>';
                        }
                    ?>
                    <table class="table table-striped table-bordered table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên phòng chiếu</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = _get_list_rooms();
                        if ($result->num_rows > 0) {
                            while ($row =  $result->fetch_assoc()) { ?>
                                <tr>
                                    <th scope="row"><?php echo $row['phong_chieu_id']; ?></th>
                                    <td class="ten-phong-chieu-td"><?php echo $row['ten_phong']; ?></td>
                                    <td class="lich-actions">
                                        <button class="btn btn-success update-phong-btn user-edit-btn" data-toggle="modal" data-target="#updatePhongChieuModal" value="<?php echo $row['phong_chieu_id'] ?>">Sửa</button>
                                        <button class="btn btn-danger delete-phong-btn user-delete-btn" data-toggle="modal" data-target="#delPhongChieuModal" onclick="_set_selected_room(<?php echo $row['phong_chieu_id'] ?>)" value="<?php echo $row['phong_chieu_id'] ?>">Xóa</button>
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
    
    <!-- Modal thêm phòng chiếu -->
    <div class="modal fade" id="addPhongChieuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPhongChieuModalLabel">Thêm phòng chiếu mới</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form id="phong-create-form">
                                    <div id="lich-manage-detail">
                                        <div class="form-group row">
                                            <label for="select-phim-chieu" class="col-md-5 col-sm-12 col-form-label">
                                                <i class="fas fa-video mr-2"></i>Tên phòng chiếu:
                                            </label>
                                            <div class="lich-manage-detail__select col-md-7 col-sm-12">
                                                <input type="text" name="phong-name" id="phong-name-input" class="form-control" placeholder="Nhập tên phòng chiếu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" id="message_create_phong"></div>
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

    <!-- Modal sửa phòng chiếu -->
    <div class="modal fade" id="updatePhongChieuModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa phòng chiếu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form id="phong-update-form">
                                    <div id="lich-manage-detail">
                                        <div class="form-group row">
                                            <label for="select-phim-chieu" class="col-md-5 col-sm-12 col-form-label">
                                                <i class="fas fa-video mr-2"></i>Tên phòng chiếu: 
                                            </label>
                                            <div class="lich-manage-detail__select col-md-7 col-sm-12">
                                                <input type="text" name="phong-name" id="phong-name-update" class="form-control" placeholder="Nhập tên phòng chiếu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-danger" id="message_update_phong"></div>
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

    <!-- Modal xóa phòng chiếu -->
    <div class="modal fade" id="delPhongChieuModal">
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
                                <div class="del-phong-title" id="room_delete_msg">Bạn có chắc chắn muốn xóa phòng chiếu chứ?</div>
                                <div class="alert alert-danger" role="alert" id="message_delete_phong"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn lich-chieu-btn" id="phong-delete-confirm-btn">Xác nhận</button>
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