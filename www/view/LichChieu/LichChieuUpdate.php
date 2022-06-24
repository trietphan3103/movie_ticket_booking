<?php
    session_start();
    error_reporting(0);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Chỉnh sửa thông tin lịch chiếu</title>
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
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Chỉnh sửa lịch chiếu</li>
                </ol>
            </div>
            <div class="col-12">
                <div id="lich-manage-detail">
                    <div>
                        Tên phim:
                        <h3 class="lich-manage-detail__title">Góa phụ đen</h3>
                    </div>
                    <div>
                        <div class="lich-manage-detail__info">
                            <i class="fas fa-user"></i>Người tạo: 
                            <span class="lich-manage-detail__creator">Nguyễn Văn A</span>
                        </div>
                        <div class="lich-manage-detail__info">
                            <i class="fas fa-calendar-day"></i>Lịch chiếu:
                        </div>
                        <!-- Bảng lịch chiếu -->
                        <div class="container lich-manage-detail__info">
                            <div class="row lich-detail-table">
                                <div class="col-3 lich-detail-column">
                                    <div class="lich-detail-table__header table-cell">Ngày</div>
                                </div>
                                <div class="col-2 lich-detail-column">
                                    <div class="lich-detail-table__header table-cell">Phòng chiếu</div>
                                </div>
                                <div class="col-5 lich-detail-column">
                                    <div class="lich-detail-table__header table-cell">Các suất chiếu</div>
                                </div>
                                <div class="col-2 lich-detail-column">
                                    <div class="lich-detail-table__header table-cell">Thao tác</div>
                                </div>
                                <!-- Chi tiết lịch chiếu theo ngày, phòng, suất chiếu -->
                                <div class="col-12 lich-detail-table__wrapper">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column__border table-cell">30/12/2021</div>
                                        <div class="col-2 lich-detail-column__border table-cell">1</div>
                                        <div class="col-5 lich-detail-column__border">
                                            <div class="table-cell__item">8:00 - 9:45</div>
                                            <div class="table-cell__item">10:00 - 11:45</div>
                                            <div class="table-cell__item">12:00 - 13:45</div>
                                            <div class="table-cell__item">14:00 - 15:45</div>
                                        </div>
                                        <div class="col-2 lich-detail-column__border lich-detail-actions table-cell">
                                            <button class="btn btn-success" id="lich-detail-edit__btn" data-toggle="modal" data-target="#editLichModal">Sửa</button>
                                            <button class="btn btn-danger" id="lich-detail-delete__btn" data-toggle="modal" data-target="#detailLichDelModal">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 lich-detail-table__wrapper">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column__border table-cell">30/12/2021</div>
                                        <div class="col-2 lich-detail-column__border table-cell">1</div>
                                        <div class="col-5 lich-detail-column__border">
                                            <div class="table-cell__item">8:00 - 9:45</div>
                                            <div class="table-cell__item">10:00 - 11:45</div>
                                            <div class="table-cell__item">12:00 - 13:45</div>
                                            <div class="table-cell__item">14:00 - 15:45</div>
                                        </div>
                                        <div class="col-2 lich-detail-column__border table-cell">
                                            <button class="btn btn-success" id="lich-detail-edit__btn" data-toggle="modal" data-target="#editLichModal">Sửa</button>
                                            <button class="btn btn-danger" id="lich-detail-delete__btn" data-toggle="modal" data-target="#detailLichDelModal">Xóa</button>
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

    <!-- Modal sửa lịch chiếu -->
    <div class="modal fade" id="editLichModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delLichModalLabel">Chỉnh sửa lịch chiếu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form id="lich-detail-edit">
                                    <div>Tên phim:
                                        <h3 class="lich-manage-detail__title">Góa phụ đen</h3>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <label for="edit-phong__input" class="col-md-4 col-sm-12">
                                            <i class="fa fa-map-marker mr-2"></i>Phòng chiếu:
                                        </label>
                                        <div class="lich-manage-detail__select col-md-8 col-sm-12">
                                            <select class="custom-select" id="edit-phong__input">
                                                <option selected>Các phòng chiếu có sẵn</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-4 col-sm-12">
                                            <i class="fas fa-calendar-day mr-2"></i>Ngày chiếu:
                                        </label>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="lich-manage-detail__select col-md-5 col-sm-12 lich-full-btn">
                                                    <div>Giờ bắt đầu</div>
                                                    <input type="datetime-local" name="edit-start-time__input" id="edit-start-time__input" class="form-control">
                                                </div>
                                                <div class="lich-manage-detail__select col-md-5 col-sm-12 lich-full-btn">
                                                    <div>Giờ kết thúc</div>
                                                    <input type="datetime-local" name="edit-end-time__input" id="edit-end-time__input" class="form-control">
                                                </div>
                                                <div class="lich-manage-detail__select col-md-2 col-sm-12 lich-full-btn">
                                                    <button type="submit" class="btn lich-chieu-btn" id="edit-time__btn">Thêm</button>
                                                </div>
                                            </div>
                                            <div class="lich-manage-detail__select lich-full-btn">
                                                <div>Ngày</div>
                                                <div class="lich-edit-time__wrapper">
                                                    <div class="row lich-edit-time__item">
                                                        <div class="col-8">
                                                            <span>8:00</span> đến <span>9:45</span>
                                                        </div>
                                                        <div class="col-4">
                                                            <i class="far fa-trash-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn lich-chieu-btn">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xóa lịch chiếu theo ngày, phòng, tất cả suất chiếu -->
    <div class="modal fade" id="detailLichDelModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delLichModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-2">
                    Bạn có chắc chắn muốn xóa toàn bộ lịch chiếu ngày 30/12/2021?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn lich-chieu-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <?php
        include("../Common/Footer.php");
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>
</html>
