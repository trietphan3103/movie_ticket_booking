<?php
    session_start();
    error_reporting(0);
    require("../../utils.php");
    require("../../api/Phim/PhimGet.api.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Thông tin phim</title>
</head>
<body>
    <?php
        require("../Common/Header.php");
    ?>
    <?php
        $result = _getPhimDetail($_GET["phim-id"]);
        if ($result->num_rows > 0) {
            while($row =  $result->fetch_assoc()) {?>
                <div id="phim-wrapper">
                    <div class="container">
                        <div class="row">
                            <ol class="breadcrumb mb-4 list-unstyled">
                                <li class="breadcrumb-item">
                                    <a href="/" class="text-decoration-none">Trang chủ</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/view/Phim/PhimList.php" class="text-decoration-none">Phim Đang Chiếu</a>
                                </li>
                                <li class="breadcrumb-item active text-uppercase text-white"><?php echo $row['ten_phim']; ?></li>
                            </ol>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <!-- Thông tin phim -->
                                <section id="phim-details-container" class="text-white">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-8">
                                            <div class="phim-details-poster d-block float-left mb-3">
                                            <img src="<?php 
                                                $poster_doc = _getPosterDoc($_GET['phim-id']);
                                                if($poster_doc->num_rows == 1) {
                                                    $poster_row = $poster_doc->fetch_assoc();
                                                    echo $poster_row['image_content'];
                                                }
                                                else {
                                                    echo '/images/phim-details/shang-chi.jpg';
                                                }
                                            ?>" alt="Black Widow">
                                            <div class="text-center">
                                                <a href="../Ve/VeCreate.php?phim_id=<?php echo $_GET["phim-id"] ?>">
                                                    <button type="submit" class="btn dat-ve-btn">ĐẶT VÉ</button>
                                                </a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <h2 class="phim-details-title text-uppercase"><?php echo $row['ten_phim']; ?></h2>
                                            <div class="phim-details-rating">
                                                <i class="fas fa-star"></i>
                                                <strong>4.5</strong><span>/5</span>
                                                <div class="d-inline ml-2">
                                                    <button type="submit" class="btn rating-btn">ĐÁNH GIÁ</button>
                                                </div>
                                            </div>
                                            <div class="phim-details-info mt-2">
                                                <div class="info-row">
                                                    <label>Thời lượng: </label>
                                                    <div class="d-inline"><?php echo $row['thoi_luong']; ?> phút</div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Diễn viên: </label>
                                                    <div class="d-inline"><?php echo $row['dien_vien']; ?></div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Quốc gia: </label>
                                                    <div class="d-inline"><?php echo $row['quoc_gia']; ?></div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Thể loại: </label>
                                                    <div class="d-inline"><?php echo $row['the_loai']; ?></div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Nhà sản xuất: </label>
                                                    <div class="d-inline"><?php echo $row['nha_san_xuat']; ?></div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Đạo diễn: </label>
                                                    <div class="d-inline"><?php echo $row['dao_dien']; ?></div>
                                                </div>
                                                <div class="info-row">
                                                    <label>Ngày phát hành: </label>
                                                    <div class="d-inline"><?php echo date("d/m/Y", strtotime($row['ngay_phat_hanh'])); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Nội dung phim -->
                                    <div id="phim-details-desc" class="my-2">
                                        <div class="col-lg-12 col-md-12 col sm-12 col-xs-12">
                                            <div>
                                                <h5 class="">NỘI DUNG PHIM</h5>
                                                <div class="phim-details-content-text text-justify">
                                                <?php echo $row['mo_ta']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <!-- Side bar -->
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-white">
                                <div id="phim-sidebar">
                                    <h4>PHIM ĐANG CHIẾU</h4>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                            $rs = _getSidebarPhim($_GET['phim-id']);

                                            if ($rs->num_rows > 0) {
                                                while ($row = $rs->fetch_assoc()) {
                                            ?>
                                                    <div class="phim-item mt-3">
                                                        <a href="/view/Phim/PhimDetail.php?phim-id=<?php echo $row['phim_id'] ?>" class="phim-item-link">
                                                            <img src="<?php 
                                                            $poster_ngang_sidebar = _getPosterNgang($row['phim_id']);
                                                            if($poster_ngang_sidebar->num_rows == 1) {
                                                                $poster_row_sidebar = $poster_ngang_sidebar->fetch_assoc();
                                                                echo $poster_row_sidebar['image_content'];
                                                            }
                                                            else {
                                                                echo '/images/phim-poster/bo-gia.jpg';
                                                            }
                                                            ?>" alt="<?php echo $row['ten_phim'] ?>" class="poster-phim">
                                                        </a>
                                                        <div class="phim-title"><?php echo $row['ten_phim'] ?></div>
                                                    </div>
                                            <?php
                                                }
                                            } else { ?>
                                                <h1>Bảng chưa có dữ liệu</h1>
                                            <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
        else {
            printf("Bảng chưa có dữ liệu");
        }
    ?>
    
    
    <?php
        include("../Common/Footer.php");
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>
</html>
