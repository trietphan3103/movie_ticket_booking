<?php
    session_start();
    error_reporting(0);
    require("../../utils.php");
    require("../../api/Phim/PhimGet.api.php");
    _require_login();
    
    $check_existed = _getPhimDetail($_GET["phim_id"]);
    if ($check_existed->num_rows <= 0) {
        header("Location: /view/utilsView/Error404.html");
    }
    $film = $check_existed->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đặt vé</title>
</head>

<body>
    <?php
        require("../Common/Header.php");
    ?>

    <div id="create-ve-wrapper">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb mb-4 list-unstyled">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/view/Phim/PhimList.php" class="text-decoration-none">Phim Đang Chiếu</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/view/Phim/PhimDetail.php?phim-id=<?php echo $film['phim_id'] ?>" class="text-decoration-none">Đặt Vé</a>
                    </li>
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white"><?php echo $film['ten_phim'] ?></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <!-- Form tạo vé phim -->
                    <section id="booking-ve">
                        <div id="create-ve-form" action="">
                            <div class="alert alert-danger text-center" id="message_ticket_danger"></div>
                            <!-- Chọn Lịch chiếu -->
                            <div class="booking-lich-chieu">
                                <h3 class="booking-lich-chieu-title">CHỌN LỊCH CHIẾU</h3>
                                <div class="booking-lich-chieu-container">
                                    <div class="form-group pick-lich">
                                        <label for="date-phim" class="lich-label">Chọn ngày giờ</label>
                                        <select class="custom-select" id="select-lich">
                                            <?php 
                                                require("../../api/LichChieu/LichChieuGet.api.php");
                                                $session_list = _get_list_session_by_film_id_distinct_by_date($_GET['phim_id']);
                                                if ($session_list->num_rows > 0) {
                                                    while ($session =  $session_list->fetch_assoc()) {
                                            ?>
                                                <option class="date_format" value="<?php echo $session['ngay_chieu'] ?>"> <?php echo $session['ngay_chieu'] ?> </option>
                                            <?php
                                                }
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group lich-chieu" id="list-gio-chieu">
                                    </div>
                                    <div class="form-group">
                                        <label for="select-ghe" class="lich-label">Chọn ghế</label>
                                        <div class="pick-ghe">
                                            <select class="custom-select" id="select-ghe">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-wrapper my-2 text-right">
                                <button type="submit" class="btn create-ve-next__btn" onclick="_show_confirm_modal()">
                                    TIẾP THEO
                                    <i class="fas fa-long-arrow-alt-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- View xác nhận thông tin vé và thanh toán -->
                    <section class="confirm-ve">
                        <h3 class="confirm-ve-title">XÁC NHẬN VÀ THANH TOÁN</h3>
                        <div class="confirm-ve-container">
                            <div class="confirm-ve-detail">
                                <h6>Vé đã đặt</h6>
                                <!-- Thông tin vé đã đặt -->
                                <div class="ve-detail-content row">
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <img src="<?php 
                                                    $poster_ngang = _getPosterNgang($_GET['phim_id']);
                                                    if($poster_ngang->num_rows == 1) {
                                                        $poster_row = $poster_ngang->fetch_assoc();
                                                        echo $poster_row['image_content'];
                                                    }
                                                ?>"
                                        alt="image.png">
                                    </div>
                                    <div class="col-md-12 col-sm-12 ve-detail-right">
                                        <div class="phim-title"><?php echo $film['ten_phim'] ?></div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div>
                                                    Ngày:
                                                    <span class="ve-detail-date" id="ve-detail-date">06/12/2021</span>
                                                </div>
                                                <div>
                                                    Giờ:
                                                    <span class="ve-detail-time" id="ve-detail-time">12:00</span>
                                                </div>                                                
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div>
                                                    Phòng chiếu:
                                                    <span class="ve-detail-phong" id="ve-detail-phong">1</span>
                                                </div>
                                                <div>
                                                    Ghế:
                                                    <span class="ve-detail-seat" id="ve-detail-seat">B6</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chọn coupon và payment -->
                                <div class="ve-detail-coupon row">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="method-option[]" class="ve-payment-title">Phương thức thanh toán</label>
                                        <div class="ve-payment">
                                            <div class="ve-payment-item">
                                                <div class="icon-wrapper">
                                                    <a href="#" title="ATM">
                                                        <img src="/images/payment-method/atm.png" alt="ATM" class="method-option">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ve-payment-item">
                                                <div class="icon-wrapper">
                                                    <a href="#" title="ZaloPay">
                                                        <img src="/images/payment-method/zalopay.png" alt="ZaloPay" class="method-option">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ve-payment-item">
                                                <div class="icon-wrapper">
                                                    <a href="#" title="Momo">
                                                        <img src="/images/payment-method/momo.png" alt="Momo" class="method-option">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="line-dash"></div>

                                <!-- Giá vé -->
                                <div class="ve-price-info">
                                    <div class="ve-column">
                                        <div class="label ve-price">Giá vé:</div>
                                        <div class="label final-price">Tổng thanh toán:</div>
                                    </div>
                                    <div class="ve-value">
                                        <div class="value ve-price">
                                            <span id="ve-price">55.000</span> <span class="value-unit">₫</span>
                                        </div>
                                        <span class="value final-price">
                                            <span id="final-price">55.000</span><span class="value-unit">₫</span> 
                                        </span>
                                    </div>
                                </div>
                                <div class="line-dash"></div>

                                <!-- Button -->
                                <div class="button-wrapper my-2 text-right">
                                    <button type="submit" class="btn back-btn" id="back-btn" onclick="_hide_confirm_modal()">
                                        <i class="fas fa-long-arrow-alt-left mr-2"></i>
                                        QUAY LẠI
                                    </button>
                                    <button type="submit" class="btn create-ve-confirm__btn" id="create-ve-confirm__btn">
                                        XÁC NHẬN
                                        <i class="fas fa-long-arrow-alt-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thông báo có lỗi xảy ra -->
    <div id="veError" class="modal fade" tabindex="-1" aria-labelledby="veErrorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="veErrorLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ve-modal__content">Có lỗi xảy ra, vui lòng thử lại sau</div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn ve-error__btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal thông báo đặt vé thành công -->
    <div id="veSuccess" class="modal fade" tabindex="-1" aria-labelledby="veSuccessLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="veSuccessLabel">Đặt vé thành công!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ve-modal__container container">
                        <div class="ve-modal__text">
                            Chi tiết vé
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="ve-modal__poster">
                                    <img src="<?php 
                                                    $poster_ngang = _getPosterNgang($_GET['phim_id']);
                                                    if($poster_ngang->num_rows == 1) {
                                                        $poster_row = $poster_ngang->fetch_assoc();
                                                        echo $poster_row['image_content'];
                                                    }
                                                ?>"
                                        alt="image.png"
                                    >
                                </div>
                                <div class="ve-modal__content">
                                    <h4 class="ve-modal__title"><?php echo $film['ten_phim'] ?></h4>
                                    <div class="ve-modal__detail">
                                        <div class="ve-modal__info">
                                            <i class="fa fa-calendar"></i>
                                            <span class="mr-5" id="ve-success-date"></span>
                                            <span >
                                                <i class="fas fa-clock"></i>
                                                <span id="ve-success-time"></span>
                                            </span>
                                        </div>
                                        <div class="ve-modal__info">
                                            <i class="fa fa-map-marker"></i>
                                            <span class="mr-5" id="ve-success-room">
                                            </span>
                                        </div>
                                        <div class="ve-modal__info">
                                            <span >
                                                <i class="fas fa-ticket-alt"></i>
                                                <span id="ve-success-seat"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/">
                        <button type="button" class="btn ve-success__btn">Về Trang chủ</button>
                    </a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/main.js"></script>
</body>

</html>