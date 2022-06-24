<?php
    session_start();
    error_reporting(0);
	require_once("./utils.php");
	require("api/Phim/PhimGet.api.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
	<title>Banana Cinema</title>
</head>

<body>
	
	<?php
	    include("view/Common/Header.php");
	?>

	<div class="container-flud">
		<!-- Slideshow container -->
		<div class="poster-slideshow slideshow-container">
			<input type="radio" name="poster-radio" id="poster-radio1">
			<input type="radio" name="poster-radio" id="poster-radio2">
			<input type="radio" name="poster-radio" id="poster-radio3">
			<input type="radio" name="poster-radio" id="poster-radio4">
			<div class="slides">
				<!-- slide images -->
				<div class="slide">
					<img src="/images/phim-poster/venom.jpg">
				</div>

				<div class="slide">
					<img src="/images/phim-poster/shang-chi.jpg">
				</div>

				<div class="slide">
					<img src="/images/phim-poster/bo-gia.jpg">
				</div>

				<div class="slide">
					<img src="/images/phim-poster/black-widow.jpg">
				</div>
			</div>
			<!-- Next and previous buttons -->
			<a class="prev-btn"><i class="fas fa-chevron-left"></i></a>
			<a class="next-btn"><i class="fas fa-chevron-right"></i></a>
			<div class="navigation-manual">
				<label for="poster-radio1" class="manual-btn manual-btn1"></label>
				<label for="poster-radio2" class="manual-btn manual-btn2"></label>
				<label for="poster-radio3" class="manual-btn manual-btn3"></label>
				<label for="poster-radio4" class="manual-btn manual-btn4"></label>
			</div>
		</div>
	</div>
	<!-- Tab Movies -->
    <div class="container mt-5">
        <div class="row">
            <div class="tab-movies col-12">
                <ul class="nav-tab nav-tab-movies">
                    <li><a class="active" href="#">PHIM ĐANG CHIẾU</a></li>
                </ul>
                <div class="row">
                    <?php
                    $result = _getListPhimDangChieu();

                    if ($result->num_rows > 0) {
                        while ($row =  $result->fetch_assoc()) {
                    ?>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 movie-item">
                            <div class="movie-card">
                                <div class="img-box" style="background-image: <?php 
                                    $poster_ngang = _getPosterNgang($row['phim_id']);
                                    if($poster_ngang->num_rows == 1) {
                                        $poster_row = $poster_ngang->fetch_assoc();
                                        echo "url('".$poster_row['image_content']."');";
                                    }
                                    else {
                                        echo "linear-gradient(black, white)";
                                    }
                                ?>">
                                </div>
                                <div class="movie-card-overlay">
                                    <a href="/view/Phim/PhimDetail.php?phim-id=<?php echo $row['phim_id'] ?>">
                                        <div class="age-limit-label">C16</div>
                                        <div class="buy-btn btn btn-outline-secondary">MUA VÉ</div>
                                    </a>
                                </div>
                            </div>
                            <div class="movie-tittle">
                                <div class="en-tittle"><?php echo $row['ten_phim'] ?></div>
                            </div>
                        </div>
                    <?php
                        }
                    } else { ?>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="tab-movies col-12">
                <ul class="nav-tab nav-tab-movies">
                    <li><a class="active" href="#">PHIM SẮP CHIẾU</a></li>
                </ul>
                <div class="row">
                <?php
                    $rs = _getListPhimSapChieu();

                    if ($rs->num_rows > 0) {
                        while ($row =  $rs->fetch_assoc()) {
                    ?>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-4 movie-item">
                            <div class="movie-card">
                                <div class="img-box" style="background-image: <?php 
                                    $poster_ngang = _getPosterNgang($row['phim_id']);
                                    if($poster_ngang->num_rows == 1) {
                                        $poster_row = $poster_ngang->fetch_assoc();
                                        echo "url('".$poster_row['image_content']."');";
                                    }
                                    else {
                                        echo "linear-gradient(black, white)";
                                    }
                                ?>">
                                </div>
                                <div class="movie-card-overlay">
                                    <a href="/view/Phim/PhimDetail.php?phim-id=<?php echo $row['phim_id'] ?>">
                                        <div class="age-limit-label">C16</div>
                                        <div class="buy-btn btn btn-outline-secondary">MUA VÉ</div>
                                    </a>
                                </div>
                            </div>
                            <div class="movie-tittle">
                                <div class="en-tittle"><?php echo $row['ten_phim'] ?></div>
                            </div>
                        </div>
                    <?php
                        }
                    } else { ?>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
	<!-- Tab Coupon -->
	<div class="container">
		<div class="row">
			<div class="tab-coupons">
				<ul class="nav-tab nav-tab-coupons">
					<li><a class="active" href="#">TÌM KHUYẾN MÃI</a></li>
				</ul>
				<div class="row">
					<div class="col-6 col-sm-4 col-md-3 col-lg-3 coupon-item">
						<div class="coupon-card">
							<div class="img-box" style="background-image: url('/images/phim-details/black-widow.jpg');">
							</div>
							<div class="coupon-card-overlay">
								<a href="#">
									<div class="buy-btn btn btn-outline-secondary">LẤY MÃ</div>
								</a>
							</div>
						</div>
						<div class="coupon-tittle">
							KHUYỄN MÃI SIÊU SALE THÁNG 12 SẬP SÀN MẠI ZÔ MẠI ZÔ !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
						</div>
					</div>
					<div class="col-6 col-sm-4 col-md-3 col-lg-3 coupon-item">
						<div class="coupon-card">
							<div class="img-box" style="background-image: url('/images/phim-details/black-widow.jpg');">
							</div>
							<div class="coupon-card-overlay">
								<a href="#">
									<div class="buy-btn btn btn-outline-secondary">LẤY MÃ</div>
								</a>
							</div>
						</div>
						<div class="coupon-tittle">
							KHUYỄN MÃI SIÊU SALE THÁNG 12 SẬP SÀN MẠI ZÔ MẠI ZÔ !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
						</div>
					</div>
					<div class="col-6 col-sm-4 col-md-3 col-lg-3 coupon-item">
						<div class="coupon-card">
							<div class="img-box" style="background-image: url('/images/phim-details/black-widow.jpg');">
							</div>
							<div class="coupon-card-overlay">
								<a href="#">
									<div class="buy-btn btn btn-outline-secondary">LẤY MÃ</div>
								</a>
							</div>
						</div>
						<div class="coupon-tittle">
							KHUYỄN MÃI SIÊU SALE THÁNG 12 SẬP SÀN MẠI ZÔ MẠI ZÔ !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
						</div>
					</div>
					<div class="col-6 col-sm-4 col-md-3 col-lg-3 coupon-item">
						<div class="coupon-card">
							<div class="img-box" style="background-image: url('/images/phim-details/black-widow.jpg');">
							</div>
							<div class="coupon-card-overlay">
								<a href="#">
									<div class="buy-btn btn btn-outline-secondary">LẤY MÃ</div>
								</a>
							</div>
						</div>
						<div class="coupon-tittle">
							KHUYỄN MÃI SIÊU SALE THÁNG 12 SẬP SÀN MẠI ZÔ MẠI ZÔ !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Introduce -->
	<div class="container">
		<div class="row">
			<div class="tab-movies tab-introduces">
				<ul class="nav-tab nav-tab-introduces nav-tab-movies">
					<li><a class="active" href="#">BANANA CINEMA</a></li>
				</ul>
				<div class="introduces-text">
					<p>Banana Cinema là một trong những công ty tư nhân đầu tiên về điện ảnh, hệ thống đã khẳng định thương hiệu là 1 trong 10 địa điểm vui chơi giải trí được yêu thích nhất. Ngoài hệ thống rạp chiếu phim hiện đại, thu hút hàng triệu lượt người đến xem, Banana Cinema còn hấp dẫn khán giả bởi không khí thân thiện cũng như chất lượng dịch vụ hàng đầu.</p> 
					<p>Đến website bananacinema.vn, quý khách sẽ được cập nhật nhanh chóng các phim hay nhất phim mới nhất đang chiếu hoặc sắp chiếu. Lịch chiếu được cập nhật đầy đủ hàng ngày hàng giờ trên trang chủ.</p>
 					<p>Hiện nay, Banana Cinema đang ngày càng phát triển hơn nữa với các chương trình đặc sắc, các khuyến mãi hấp dẫn, đem đến cho khán giả những bộ phim bom tấn của thế giới và Việt Nam nhanh chóng và sớm nhất.</p>
				</div>
			</div>
		</div>
	</div>

    <?php
	    include("view/Common/Footer.php");
	?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="/main.js"></script>
</body>

</html>