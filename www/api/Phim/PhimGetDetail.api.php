<?php
    require_once '../../utils.php';
    require_once './PhimGet.api.php';
    $conn = connection();

    if(!empty($_GET['phim-id'])) {
        // check existed
        $stmt = $conn->prepare("SELECT * FROM `PHIM` WHERE phim_id = ?");
        $phim_id = $_GET['phim-id'];
        $stmt->bind_param("i", $phim_id);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) != 1) {
            http_response_code(404);
            echo "Không tồn tại phim với id yêu cầu";
            return;
        }

        
        $result = _getPhimDetail($phim_id);
        $result = $result->fetch_assoc();

        $poster_ngang = _getPosterNgang($phim_id);
        if($poster_ngang->num_rows == 1) {
            $poster_ngang = $poster_ngang->fetch_assoc();
        } else {
            $poster_ngang = '';
        };
        $poster_doc = _getPosterDoc($phim_id);
        if($poster_doc->num_rows == 1) {
            $poster_doc = $poster_doc->fetch_assoc();
        } else {
            $poster_doc = '';
        };
        
        $result['poster_doc'] = $poster_doc;
        $result['poster_ngang'] = $poster_ngang;

        echo json_encode($result);
    } else {
        http_response_code(404);
        echo "Vui lòng truyền id của phim muốn lấy thông tin";
        return;
    }
?>
