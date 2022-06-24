<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
    ];
   
    $queryStr = "DELETE FROM `LICH_CHIEU` WHERE lich_chieu_id = ?;";

    $stmt = $conn->prepare($queryStr);
    $stmt->bind_param("s", $lich_chieu_id);
    $lich_chieu_id = $_POST['lich_chieu_id']; 
    $rs = $stmt->execute();
    
    if($rs){
        http_response_code(200);
        echo "Success";
        return;
    }else{
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