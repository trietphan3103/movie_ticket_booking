<?php 
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Ten phong length condition" => "Độ dài tối đa của tên phòng chiếu là 255 kí tự",
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
    ];

    if (!empty($_POST['ten_phong'])) {
        // Check length
        if (strlen($_POST['ten_phong']) > 255) {
            http_response_code(422);
            echo $exceptionTranslation["Ten phong length condition"];
            return;
        }

        // check existed phong chieu
        $stmt = $conn->prepare("SELECT * FROM `PHONG_CHIEU` WHERE `ten_phong` = ?");
        $ten_phong = $_POST['ten_phong'];
        $stmt->bind_param("s", $ten_phong);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) > 0) {
            http_response_code(409);
            echo "Phòng chiếu này đã được tạo trước đó";
            return;
        }

        // Create new phong chieu
        $ten_phong = $_POST['ten_phong'];

        $stmt = $conn->prepare("INSERT INTO `PHONG_CHIEU` (`ten_phong`) VALUES (?);");
        $stmt->bind_param("s", $ten_phong);
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
