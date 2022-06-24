<?php
    session_start();
    error_reporting(0);
    require("../../api/Product/ProductGet.api.php");
    require("../../utils.php");

    $result = _getListPhim();
    // printf($result);

    if ($result->num_rows > 0) {
        while($row =  $result->fetch_assoc()) {
        ?>
            <div class="my-3">
                <a href="/view/Product/ProductDetail.php?phim-id=<?php echo $row['phim_id'] ?>">Xem chi tiết phim có id=<?php echo $row['phim_id'] ?>: <?php echo $row['ten_phim'] ?></a>
            </div>
        <?php
        }
    }
    else {
        echo "Bảng chưa có dữ liệu";
    }

    echo "demo"
?>