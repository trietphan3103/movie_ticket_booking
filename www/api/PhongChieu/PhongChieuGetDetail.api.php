<?php
    require_once '../../utils.php';
    require_once './PhongChieuGet.api.php';
    $conn = connection();

    if(!empty($_GET['phong_chieu_id'])) {
        // check existed
        $stmt = $conn->prepare("SELECT * FROM `PHONG_CHIEU` WHERE phong_chieu_id = ?");
        $phong_chieu_id = $_GET['phong_chieu_id'];
        $stmt->bind_param("i", $phong_chieu_id);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) != 1) {
            http_response_code(404);
            echo "Không tồn tại phòng chiếu với id yêu cầu";
            return;
        }

        $result = _get_room_detail($phong_chieu_id);
        $result = $result->fetch_assoc();
        echo json_encode($result);
    } else {
        http_response_code(404);
        echo "Vui lòng truyền id của phòng chiếu muốn lấy thông tin";
        return;
    }
?>