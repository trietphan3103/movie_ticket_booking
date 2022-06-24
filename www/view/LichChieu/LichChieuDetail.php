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
    <title>Thông tin lịch chiếu</title>
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
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Thông tin lịch chiếu</li>
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
                        <div class="lich-manage-detail__info">
                            <div class="row lich-detail-table">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column">
                                            <div class="lich-detail-table__header table-cell">Ngày</div>
                                        </div>
                                        <div class="col-3 lich-detail-column">
                                            <div class="lich-detail-table__header table-cell">Phòng chiếu</div>
                                        </div>
                                        <div class="col-6 lich-detail-column">
                                            <div class="lich-detail-table__header table-cell">Các suất chiếu</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Chi tiết lịch chiếu theo ngày, phòng, suất chiếu -->
                                <div class="col-12 lich-detail-table__wrapper">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column__border table-cell">30/12/2021</div>
                                        <div class="col-3 lich-detail-column__border table-cell">1
                                        </div>
                                        <div class="col-6 lich-detail-column__border">
                                            <div class="table-cell__item">8:00 - 9:45</div>
                                            <div class="table-cell__item">10:00 - 11:45</div>
                                            <div class="table-cell__item">12:00 - 13:45</div>
                                            <div class="table-cell__item">14:00 - 15:45</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 lich-detail-table__wrapper">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column__border table-cell">31/12/2021</div>
                                        <div class="col-3 lich-detail-column__border table-cell">3</div>
                                        <div class="col-6 lich-detail-column__border">
                                            <div class="table-cell__item">8:00 - 9:45</div>
                                            <div class="table-cell__item">10:00 - 11:45</div>
                                            <div class="table-cell__item">12:00 - 13:45</div>
                                            <div class="table-cell__item">14:00 - 15:45</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 lich-detail-table__wrapper">
                                    <div class="row">
                                        <div class="col-3 lich-detail-column__border table-cell">01/01/2022</div>
                                        <div class="col-3 lich-detail-column__border table-cell">2</div>
                                        <div class="col-6 lich-detail-column__border">
                                            <div class="table-cell__item">8:00 - 9:45</div>
                                            <div class="table-cell__item">10:00 - 11:45</div>
                                            <div class="table-cell__item">12:00 - 13:45</div>
                                            <div class="table-cell__item">14:00 - 15:45</div>
                                            <div class="table-cell__item">16:00 - 17:45</div>
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

    <?php
        include("../Common/Footer.php");
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>
</html>
