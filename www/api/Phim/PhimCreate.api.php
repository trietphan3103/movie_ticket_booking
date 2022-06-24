<?php 
    require_once '../../utils.php';
    $conn = connection();
    $exceptionTranslation = [
        "Ten phim length condition" => "Độ dài tối đa của tên phim là 2550 kí tự",
        "Quoc gia length condition" => "Độ dài tối đa của quốc gia là 255 kí tự",
        "Nha san xuat length condition" => "Độ dài tối đa của nhà sản xuất là 255 kí tự",
        "Dien vien length condition" => "Độ dài tối đa của diễn viên là 2550 kí tự",
        "Dao dien length condition" => "Độ dài tối đa của đạo diễn là 2550 kí tự",
        "The loai length condition" => "Độ dài tối đa của thể loại là 2550 kí tự",
        "Ngay phat hanh condition" => "Ngày phát hành phải là sau hôm nay",
        "Thoi luong condition" => "Thời lượng phải lớn hơn 0",
        "Error" => "Something went wrong, please try again later",
    ];

    if (
        !empty($_FILES['poster_doc']['name']) && !empty($_FILES['poster_ngang']['name'])
        && !empty($_POST['ten_phim']) && !empty($_POST['nha_san_xuat'])
        && !empty($_POST['quoc_gia']) && !empty($_POST['dien_vien']) && !empty($_POST['dao_dien'])
        && !empty($_POST['the_loai']) && !empty($_POST['ngay_phat_hanh']) && !empty($_POST['mo_ta'])
        && isset($_POST['thoi_luong'])
    ) {

        // check file error
        if ($_FILES['poster_doc']['error'] > 0) {
            http_response_code(422);
            echo 'Poster dọc bị lỗi, vui lòng chọn ảnh khác';
            return;
        };

        if ($_FILES['poster_ngang']['error'] > 0) {
            http_response_code(422);
            echo 'Poster ngang bị lỗi, vui lòng chọn ảnh khác';
            return;
        };

        // check existed file
        $poster_doc_path = '/images/phim-details/'.$_FILES['poster_doc']['name'];
        $poster_ngang_path = '/images/phim-poster/'.$_FILES['poster_ngang']['name'];
        if (file_exists($poster_doc_path)) {
            http_response_code(409);
            echo "Ảnh poster dọc đã được sử dụng cho phim khác";
            return;
        };
        if (file_exists($poster_ngang_path)) {
            http_response_code(409);
            echo "Ảnh poster ngang đã được sử dụng cho phim khác";
            return;
        };

        // Check existed images in db
        $stmt = $conn->prepare("SELECT * FROM `IMAGES` WHERE image_content = ?");
        $stmt->bind_param("s", $poster_doc_path);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) > 0) {
            http_response_code(409);
            echo "Ảnh poster dọc đã được sử dụng cho phim khác";
            return;
        };

        $stmt = $conn->prepare("SELECT * FROM `IMAGES` WHERE image_content = ?");
        $stmt->bind_param("s", $poster_ngang_path);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) > 0) {
            http_response_code(409);
            echo "Ảnh poster dọc đã được sử dụng cho phim khác";
            return;
        };

        // Check length
        if (strlen($_POST['ten_phim']) > 2550) {
            http_response_code(422);
            echo $exceptionTranslation["Ten phim length condition"];
            return;
        };

        if (strlen($_POST['nha_san_xuat']) > 255) {
            http_response_code(422);
            echo $exceptionTranslation["Nha san xuat length condition"];
            return;
        };

        if (strlen($_POST['quoc_gia']) > 255) {
            http_response_code(422);
            echo $exceptionTranslation["Quoc gia length condition"];
            return;
        };

        if (strlen($_POST['dien_vien']) > 2550) {
            http_response_code(422);
            echo $exceptionTranslation["Dien vien length condition"];
            return;
        };

        if (strlen($_POST['dao_dien']) > 2550) {
            http_response_code(422);
            echo $exceptionTranslation["Dao dien length condition"];
            return;
        };

        if (strlen($_POST['the_loai']) > 2550) {
            http_response_code(422);
            echo $exceptionTranslation["The loai length condition"];
            return;
        };

        // check thoi_luong
        if ($_POST['thoi_luong'] <= 0) {
            http_response_code(422);
            echo $exceptionTranslation["Thoi luong condition"];
            return;
        };

        //check ngay_phat_hanh
        $date_now = date('Y-m-d');
        if ($_POST['ngay_phat_hanh'] <= $date_now) {
            echo $exceptionTranslation["Ngay phat hanh condition"];
            return;
        };

        // Check existed phim
        $stmt = $conn->prepare("SELECT * FROM `PHIM` WHERE ten_phim = ?");
        $ten_phim = $_POST['ten_phim'];
        $stmt->bind_param("s", $ten_phim);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) > 0) {
            http_response_code(409);
            echo "Phim này đã được tạo trước đó";
            return;
        };

        // Create new phim
        $stmt = $conn->prepare("SELECT `user_id` FROM `USERS` WHERE `USER_NAME` = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $created_by_rs = $stmt->get_result();

        if ($created_by_rs->num_rows == 1) {
            $row = $created_by_rs->fetch_assoc();
            $created_by = $row['user_id'];
        };

        $ten_phim = $_POST['ten_phim'];
        $nha_san_xuat = $_POST['nha_san_xuat'];
        $quoc_gia = $_POST['quoc_gia'];
        $dien_vien = $_POST['dien_vien'];
        $dao_dien = $_POST['dao_dien'];
        $the_loai = $_POST['the_loai'];
        $ngay_phat_hanh = $_POST['ngay_phat_hanh'];
        $mo_ta = $_POST['mo_ta'];
        $thoi_luong = $_POST['thoi_luong'];

        $stmt = $conn->prepare("INSERT INTO `PHIM` (`created_by`, `ten_phim`, `nha_san_xuat`, `quoc_gia`, `dien_vien`, `dao_dien`, `the_loai`, `ngay_phat_hanh`, `mo_ta`, `thoi_luong`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("issssssssi", $created_by, $ten_phim, $nha_san_xuat, $quoc_gia, $dien_vien, $dao_dien, $the_loai, $ngay_phat_hanh, $mo_ta, $thoi_luong);
        $rs = $stmt->execute();

        if ($rs) {
            //Upload file
            move_uploaded_file($_FILES['poster_doc']['tmp_name'], '../../images/phim-details/'.$_FILES['poster_doc']['name']);
            move_uploaded_file($_FILES['poster_ngang']['tmp_name'], '../../images/phim-poster/'.$_FILES['poster_ngang']['name']);

            //store file path to db
            $last_id = $conn->insert_id;
            $stmt = $conn->prepare("INSERT INTO `IMAGES` (`image_id`, `image_content`, `phim_id`, `status`, `the_loai`) VALUES (NULL, ?, ?, 0, 0)");
            $stmt->bind_param("si", $poster_doc_path, $last_id);
            $poster_doc_rs = $stmt->execute();

            $stmt = $conn->prepare("INSERT INTO `IMAGES` (`image_id`, `image_content`, `phim_id`, `status`, `the_loai`) VALUES (NULL, ?, ?, 1, 1)");
            $stmt->bind_param("si", $poster_ngang_path, $last_id);
            $poster_ngang_rs = $stmt->execute();
            
            if($poster_doc_rs && $poster_ngang_rs){
                http_response_code(200);
                echo "Success";
                return;
            }else{
                http_response_code(500);
                echo $exceptionTranslation["Error"];
                return;
            }
        } else {
            http_response_code(500);
            echo htmlspecialchars($stmt->error);
            // if (isset($exceptionTranslation[htmlspecialchars($stmt->error)])) {
            //     echo $exceptionTranslation[htmlspecialchars($stmt->error)];
            //     return;
            // } else {
            //     echo $exceptionTranslation["Error"];
            //     return;
            // }
        }
        return;
    } else {
        http_response_code(422);
        echo "Please fill enought information";
        return;
    };
?>
