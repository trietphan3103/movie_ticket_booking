<?php
    session_start();
    error_reporting(0);
    require("../../utils.php");
    _require_login();
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
    <title>Thông tin người dùng</title>
</head>

<body>
    <?php
        include("../../view/Common/Header.php");
    ?>
    
    <?php
        require("../../api/User/UserGet.api.php");
        $userInfo = _get_user_information();
    ?>

    <div id="poster"><img src="/images/user-details/poster.jpg"> <h1 class="poster-title user-detail-title">THÔNG TIN CỦA BẠN</h1> </div>
    <div class="container-flud user-detail-page">
        <div class="container user-details-contain row">
              <div class="tab active col-6" id="tab-1">Thông tin người dùng</div>
              <div class="tab col-6" id="tab-2">Vé của bạn</div>
        </div>

        <div class="container tab-content-contain">
            <div class="tab-content tab-content-active" id="tab-1-content">
                <form id="user-detail-form" class="container mx-auto px-4 pb-3 pt-5 rounded-lg shadow dp-grid">
                    <div class="alert alert-danger" id="message_update_user_danger"></div>
                    <div class="alert alert-info" id="message_update_user_infor"></div>
                    <div class="row">
                        <div class="item col-md-6 col-sm-12">
                                <label>Họ tên: </label>
                                <input type="text" class="form-control" placeholder="Please fill your information" <?php echo "value = '".$userInfo['ho_ten']."'" ?> id="ho_ten">
                        </div>
                        <div class="item col-md-2 col-sm-6">
                                <label>Giới tính: </label>
                                <select name="gender" class="custom-select form-control" id="gioi_tinh">
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                        </div>
                        <div class="item col-md-4 col-sm-6">
                                <label>Ngày sinh: </label>
                                <input type="date" class="form-control" name="birthday" <?php echo "value = '".$userInfo['ngay_sinh']."'" ?> id="ngay_sinh">
                        </div>
                        <div class="item col-md-6 col-sm-12">
                            <label>Số điện thoại: </label>
                            <input type="text" class="form-control" placeholder="Please fill your information" <?php echo "value = '".$userInfo['sdt']."'" ?> id="sdt">
                        </div>
                        <div class="item col-md-6 col-sm-12">
                            <label>CMND: </label>
                            <input type="text" class="form-control" placeholder="Please fill your information" <?php echo "value = '".$userInfo['cmnd']."'" ?> id="cmnd">
                        </div>
                    </div>
                    <div class="row">
                        <div class="item col-12 col-sm-6 col-md-4 col-lg-3">
                            <input type="submit" class="btn" value="UPDATE">
                        </div>
                    </div>

                </form>
            </div>
            <div class="tab-content" id="tab-2-content">
                <div class="row ticket-box">
                    <div class="col-12">
                        <div class="row">
                            <?php
                            $tickets = _get_user_tickets();

                            if ($tickets->num_rows > 0) {
                                while ($ticket =  $tickets->fetch_assoc()) {
                            ?>
                                <div class="ticket card col-lg-6 col-sm-12">
                                    <section class="date">
                                        <time class="ve_phim_time_main" <?php echo "datetime = '".$ticket['gio_bat_dau']."'" ?>>
                                            <span class="time-main">29</span>
                                            <span>11</span>
                                            <span>2021</span>
                                        </time>
                                    </section>
                                    <section class="card-cont">
                                        <div class="even-info"><i class="fas fa-video"></i>FILM: </div>
                                        <h3> <?php echo $ticket['ten_phim'] ?></h3>
                                        <div class="even-date">
                                            <i class="fa fa-calendar"></i>
                                            <time>
                                                <span class="ve_phim_time_start" <?php echo "value = '".$ticket['gio_bat_dau']."'" ?>></span>
                                            </time>
                                        </div>
                                        <div class="even-date">
                                            <i class="fa fa-calendar"></i>
                                            <time>
                                                <span class="ve_phim_time_end" <?php echo "value = '".$ticket['gio_ket_thuc']."'" ?>></span>
                                            </time>
                                        </div>
                                        <div class="even-info">
                                        <i class="fa fa-map-marker"></i>
                                        <p>
                                            ROOM: <?php echo $ticket['ten_phong'] ?>
                                        </p>
                                        </div>
                                    </section>
                                </div>
                            <?php
                                }
                            } else {
                                echo '<div class="text-center"> Bạn không có vé mới </div>';
                            } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="tab-3-content">
                3
            </div>
            
        </div>
    </div>  

	<?php
		include("../../view/Common/Footer.php");
	?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.16/moment-timezone-with-data.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>
    <script src="../../main.js"></script>
</body>

</html>