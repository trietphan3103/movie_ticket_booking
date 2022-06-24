<?php
    require_once '../../utils.php';
    $conn = connection();

    if(isset($_POST['ten_phim']) && isset($_POST['mo_ta']) && isset($_POST['thoi_luong'])){
        $stmt = $conn->prepare("INSERT INTO PHIM(ten_phim,mo_ta,thoi_luong, created_by) VALUES (?, ?, ?, 1)");
        // i - integer
        // d - double
        // s - string
        // b - BLOB
        $stmt->bind_param("ssi", $ten_phim, $mo_ta, $thoi_luong);

        $ten_phim = $_POST['ten_phim'];
        $mo_ta = $_POST['mo_ta'];
        $thoi_luong = $_POST['thoi_luong'];
        $stmt->execute();

        // $result = mysqli_query($conn,$sql_insert);
    }
    else{
        return "Error, cannot create phim";
    }

?>