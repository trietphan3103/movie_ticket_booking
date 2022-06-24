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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Danh sách phim</title>
</head>

<body>
    <?php
    // require("utils.php");
    include("../Common/Header.php");
    ?>

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
                        <h1>Bảng chưa có dữ liệu</h1>
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
                        <h1>Bảng chưa có dữ liệu</h1>
                    <?php
                    }
                    ?>
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