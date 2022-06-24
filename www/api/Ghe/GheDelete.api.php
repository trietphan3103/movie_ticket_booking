<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Not existed ghe condition" => "Không tồn tại ghế có ID cần xóa",
        "Existed ghe in ve condition" => "Ghế muốn xóa đã được đặt vé",
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
    ];
    $ghe_id = $_POST['ghe_id'];

    if (isset($_POST['ghe_id'])) {
        // check ghế tồn tại
        $stmt = $conn->prepare("SELECT * FROM `GHE` WHERE `ghe_id` = ?");
        $stmt->bind_param("i", $ghe_id);
        $stmt->execute();
        $check_exited_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_rs) == 0) {
            http_response_code(409);
            echo $exceptionTranslation["Not existed ghe condition"];
            return;
        };

        // check tồn tại ghế trong vé phim đã đặt
        $stmt = $conn->prepare("SELECT * FROM `GHE` 
                                WHERE `ghe_id` = ?
                                and `ghe_id` IN (SELECT `VE_PHIM`.`ghe_id` 
                                                   FROM `LICH_CHIEU`, `VE_PHIM` 
                                                   WHERE `LICH_CHIEU`.`lich_chieu_id` = `VE_PHIM`.`lich_chieu_id`
                                                   and DATE(`gio_bat_dau`) >= CURDATE())");
        $stmt->bind_param("i", $ghe_id);
        $stmt->execute();
        $check_exited_ve_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_ve_rs) > 0) {
            http_response_code(409);
            echo $exceptionTranslation["Existed ghe in ve condition"];
            return;
        };

        // check tồn tại ghế trong vé phim quá khứ
        $stmt = $conn->prepare("SELECT * FROM `GHE` 
                                WHERE `ghe_id` = ?
                                and `ghe_id` IN (SELECT `VE_PHIM`.`ghe_id` 
                                                   FROM `LICH_CHIEU`, `VE_PHIM` 
                                                   WHERE `LICH_CHIEU`.`lich_chieu_id` = `VE_PHIM`.`lich_chieu_id`
                                                   and DATE(`gio_bat_dau`) < CURDATE())");
        $stmt->bind_param("i", $ghe_id);
        $stmt->execute();
        $check_exited_ve_rs = $stmt->get_result();

        if (mysqli_num_rows($check_exited_ve_rs) > 0) {
            $stmt = $conn->prepare("UPDATE `VE_PHIM` SET `ghe_id` = NULL WHERE `ghe_id` = ?");
            $stmt->bind_param("i", $ghe_id);
            $check_past_ve_rs = $stmt->execute();

            if ($check_past_ve_rs > 0) {
                $stmt = $conn->prepare("DELETE FROM `GHE` WHERE `ghe_id` = ?;"); 
                $stmt->bind_param("i", $ghe_id);
                $ghe_result = $stmt->execute();
    
                if($ghe_result){
                    http_response_code(200);
                    echo "Success";
                    return;
                }else{
                    http_response_code(500);
                    echo "Khong xoa duoc";
                    return;
                }
                return;
            } else {
                http_response_code(500);
                echo "koooo";
                return;
            }
        };

        // delete phong chieu
        $stmt = $conn->prepare("DELETE FROM `GHE` WHERE `ghe_id` = ?;"); 
        $stmt->bind_param("i", $ghe_id);
        $ghe_rs = $stmt->execute();
    
        if($ghe_rs) {
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
    } else {
        http_response_code(422);
        echo "Vui lòng điền đầy đủ thông tin";
        return;
    }  
?>
