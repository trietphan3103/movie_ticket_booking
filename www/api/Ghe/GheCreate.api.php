<?php 
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Ma ghe length condition" => "Độ dài tối đa của tên phòng chiếu là 10 kí tự",
        "Ghe existed condition" => "Ghế này đã được tạo trước đó",
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
    ];

    if (!empty($_POST['ma_ghe']) && !empty($_POST['phong_chieu_id'])) {
        // Check length
        if (strlen($_POST['ma_ghe']) > 10) {
            http_response_code(422);
            echo $exceptionTranslation["Ma ghe length condition"];
            return;
        }

        // check existed ghe
        $stmt = $conn->prepare("SELECT * FROM `GHE` WHERE `phong_chieu_id` = ? AND `ma_ghe` = ?");
        $phong_chieu_id = $_POST['phong_chieu_id'];
        $ma_ghe = $_POST['ma_ghe'];
        $stmt->bind_param("is", $phong_chieu_id, $ma_ghe);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) > 0) {
            http_response_code(409);
            echo $exceptionTranslation["Ghe existed condition"];
            return;
        }

        // Create new ghe
        $ma_ghe = $_POST['ma_ghe'];
        $phong_chieu_id = $_POST['phong_chieu_id'];

        $stmt = $conn->prepare("INSERT INTO `GHE` (`phong_chieu_id`, `ma_ghe`) VALUES (?, ?);");
        $stmt->bind_param("is", $phong_chieu_id, $ma_ghe);
        $rs = $stmt->execute();

        if ($rs) {
            http_response_code(200);
            echo "Success";
            return;
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
    };
?>
