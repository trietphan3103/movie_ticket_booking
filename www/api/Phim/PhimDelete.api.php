<?php
    require_once '../../utils.php';
    require("../../api/Phim/PhimGet.api.php");
    $conn = connection();
    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
    ];

    if (
        isset($_POST['phim_id'])
    ) {
        $phim_id = $_POST['phim_id'];

        // Check existed phim
        $stmt = $conn->prepare("SELECT * FROM `PHIM` WHERE `phim_id` = ?");
        $stmt->bind_param("i", $phim_id);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) == 0) {
            http_response_code(409);
            echo "Không tồn tại phim có ID cần xóa";
            return;
        };

        // Check existed lich_chieu
        $stmt = $conn->prepare("SELECT * FROM `LICH_CHIEU` WHERE `phim_id` = ?");
        $stmt->bind_param("i", $phim_id);
        $stmt->execute();
        $check_exited_lich_chieu_rs = $stmt->get_result();

        if (mysqli_num_rows( $check_exited_lich_chieu_rs) > 0) {
            http_response_code(409);
            echo "Phim muốn xóa tồn tại lịch chiếu";
            return;
        };

        $poster_doc = _getPosterDoc($phim_id);
        if($poster_doc->num_rows == 1) {
            $poster_doc_row = $poster_doc->fetch_assoc();
            unlink("../..".$poster_doc_row['image_content']);
        }

        $poster_ngang = _getPosterNgang($phim_id);
        if($poster_ngang->num_rows == 1) {
            $poster_ngang_row = $poster_ngang->fetch_assoc();
            unlink("../..".$poster_ngang_row['image_content']);
        }

        $stmt = $conn->prepare("DELETE FROM `IMAGES` WHERE `IMAGES`.`phim_id` = ?");
        $stmt->bind_param("i", $phim_id);
        $rs = $stmt->execute();
        
        if ($rs) {
            $stmt = $conn->prepare("DELETE FROM `PHIM` WHERE `PHIM`.`phim_id` = ?");
            $stmt->bind_param("i", $phim_id);
            $phim_rs = $stmt->execute();

            if($phim_rs){
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
            if (isset($exceptionTranslation[htmlspecialchars($stmt->error)])) {
                echo $exceptionTranslation[htmlspecialchars($stmt->error)];
                return;
            } else {
                echo $exceptionTranslation["Error"];
                return;
            }
        }
        return;
    } else {
        http_response_code(422);
        echo "Vui lòng điền đầy đủ thông tin";
        return;
    }
?>
