<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Not existed phong chieu" => "Không tồn tại phòng chiếu có ID cần xóa",
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
    ];
    $phong_chieu_id = $_POST['phong_chieu_id'];

    // delete phong chieu
    $stmt = $conn->prepare("DELETE FROM `PHONG_CHIEU` WHERE `phong_chieu_id` = ?;"); 
    $stmt->bind_param("i", $phong_chieu_id);
    $phong_chieu_rs = $stmt->execute();

    if($phong_chieu_rs) {
        http_response_code(200);
        echo "Success";
        return;
    } else {
        http_response_code(500);
        // echo $exceptionTranslation["Error"];
        // echo htmlspecialchars($stmt->error);
        if(isset($exceptionTranslation[htmlspecialchars($stmt->error)])){
            echo $exceptionTranslation[htmlspecialchars($stmt->error)];
        }else{
            echo $exceptionTranslation["Error"];
        }
        return;
    }
        
?>
