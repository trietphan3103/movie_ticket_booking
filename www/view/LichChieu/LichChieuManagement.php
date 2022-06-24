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
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>Quản lý lịch chiếu</title>
</head>

<body>
    <?php
        require("../Common/Header.php");
    ?>

    <div id="lich-management-wrapper">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb mb-4 list-unstyled">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none">Trang chủ</a>
                    </li>
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Quản lý lịch chiếu</li>
                </ol>
            </div>
            <div class="add-lich-chieu__btn">
                <div class="btn_contain" href="#" data-toggle="modal" data-target="#addLichModal">
                    <label>Thêm lịch chiếu</label>
                    <i class="fas fa-plus-circle add_btn"></i>
                </div>
            </div>
            <div class="filter">
                <select class="custom-select" id="session_film_filter" 

                >
                    <option>ALL</option>
                    <?php
                        require_once("../../api/Phim/PhimGet.api.php");
                        $film_list = _getListPhim();
                        if ($film_list->num_rows > 0) {
                            while ($film =  $film_list->fetch_assoc()) { 
                    ?>
                        <option value="<?php echo $film['phim_id'] ?>" 
                            <?php
                                if(isset($_GET['film'])){
                                   if($_GET['film'] == $film['phim_id']){
                                       echo "selected";
                                   }
                                }
                            ?>
                        ><?php echo $film['ten_phim'] ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 lich-table">
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
                                <th scope="col">Mã lịch chiếu</th>
                                <th scope="col">Phim</th>
                                <th scope="col">Phòng chiếu</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Khung giờ</th>
                                <th scope="col">Giá vé</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require("../../api/LichChieu/LichChieuGet.api.php");
                                if(isset($_GET['film'])){
                                    $session_list = _get_list_session_by_film_id($_GET['film']);
                                }else{
                                    $session_list = _get_list_session();
                                }
                                if ($session_list->num_rows > 0) {
                                    while ($session =  $session_list->fetch_assoc()) {
                            ?>
                                    <tr class="phim-item align-middle">
                                        <td scope="row"><?php echo $session['lich_chieu_id']; ?></th>
                                        <td class="ten-phim-td film-name-session">
                                            <a href="/view/Phim/PhimManagementDetail.php?phim-id=<?php echo $session['phim_id'] ?>">
                                                <?php echo $session['ten_phim']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $session['ten_phong'] ?></td>
                                        <td><?php echo $session['creator']; ?></td>
                                        <td>
                                            <b class="datetime" value="<?php echo $session['gio_bat_dau']; ?>"><?php echo $session['gio_bat_dau']; ?></b> 
                                            - 
                                            <b class="datetime" value="<?php echo $session['gio_ket_thuc']; ?>"><?php echo $session['gio_ket_thuc']; ?></b></td>
                                        <td><?php echo $session['gia']; ?></d>
                                        <td>
                                            <button class="btn btn-danger phim-delete-btn user-delete-btn" data-toggle="modal" data-target="#delLichModal" onclick="_set_selected_session(<?php echo $session['lich_chieu_id'] ?>)" value="<?php echo $session['lich_chieu_id'] ?>">Xóa</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else { ?>
                                <tr><td colspan = 7 class="text-center">Không có lịch chiếu nào mới trong tương lai</td></tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal thêm lịch chiếu -->
    <div class="modal fade" id="addLichModal">
        <form id="session_create_form" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delLichModalLabel">Thêm lịch chiếu mới</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="alert alert-danger" id="message_session_danger"></div>
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div id="lich-manage-detail">
                                        <div class="form-group row">
                                            <label for="select-phim-chieu" class="col-md-4 col-sm-12 col-form-label">
                                                <i class="fas fa-video mr-2"></i>Chọn phim: 
                                            </label>
                                            <div class="lich-manage-detail__select col-md-8 col-sm-12">
                                                <select class="custom-select" id="phim_id">
                                                    <?php
                                                        $film_list = _getListPhim();
                                                        if ($film_list->num_rows > 0) {
                                                            while ($film =  $film_list->fetch_assoc()) { 
                                                    ?>
                                                        <option value="<?php echo $film['phim_id'] ?>"><?php echo $film['ten_phim'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="update-phong-chieu" class="col-md-4 col-sm-12 col-form-label">
                                                <i class="fa fa-map-marker mr-2"></i>Phòng chiếu:
                                            </label>
                                            <div class="lich-manage-detail__select col-md-8 col-sm-12">
                                                <select class="custom-select" id="phong_chieu_id">
                                                    <?php
                                                        require("../../api/PhongChieu/PhongChieuGet.api.php");
                                                        $room_list = _get_list_rooms();
                                                        if ($room_list->num_rows > 0) {
                                                            while ($room =  $room_list->fetch_assoc()) { 
                                                    ?>
                                                        <option value="<?php echo $room['phong_chieu_id'] ?>"><?php echo $room['ten_phong'] ?></option>
                                                    <?php
                                                        }
                                                    }else{
                                                        echo "<option value='-1'>Không có phòng chiếu</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="update-phong-chieu" class="col-md-4 col-sm-12 col-form-label">
                                                <i class="fa fa-map-marker mr-2"></i>Giá:
                                            </label>
                                            <div class="lich-manage-detail__select col-md-8 col-sm-12">
                                                <input type="numer" id="gia" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="time-start" class="col-md-4 col-sm-12 col-form-label">
                                                <i class="fas fa-calendar-day"></i>
                                                Lịch chiếu: 
                                            </label>
                                            <div class="col-12 my-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="lich-start-input">Ngày bắt đầu</label>
                                                        <input type="datetime-local" class="form-control" id="gio_bat_dau">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="lich-end-input">Ngày kết thúc</label>
                                                        <input type="datetime-local" class="form-control" id="gio_ket_thuc">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <input type="submit" class="btn lich-chieu-btn" value="Tạo mới"></button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal xóa lịch chiếu -->
    <div class="modal fade" id="delLichModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delLichModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-2" id="modal_delete_msg">
                    Bạn có chắc chắn muốn xóa suất này, hành động này sẽ xóa luôn tất cả các vé của suất này?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn lich-chieu-btn" id="delete_session_confirm_btn">Xác nhận</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/main.js"></script>
</body>

</html>