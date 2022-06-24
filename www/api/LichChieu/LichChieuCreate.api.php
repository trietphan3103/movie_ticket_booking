<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
        "invalid_datetime" => "Phòng chiếu đã được sử dụng trong khung giờ này",
    ];

    $attrArr = array();
    $valuesArr = array();
    $keyStr = "(";
    $createStr = " (";

    // Init default value
    $_POST["created_by"] = _get_current_user_id();

    foreach ($_POST as $key => $value){
        if(!_validate_not_null($value)){
            http_response_code(422);
            echo $exceptionTranslation["Empty field"];
            return;
        }
        array_push($attrArr, $key);
        array_push($valuesArr, $value);
        $keyStr = $keyStr.$key.",";
        $createStr = $createStr." ?,";
    }


    /* 
    * Validate lich chieu 
    * @return 1 if validated otherwise return 0
    */
    $stmt = $conn->prepare("SELECT _validate_film_session(?, ?, ?) as result");
    $stmt->bind_param("sss", $p_phong_chieu_id, $p_time_start, $p_time_end);
    $p_phong_chieu_id = $_POST['phong_chieu_id'];
    $p_time_start = $_POST['gio_bat_dau']; 
    $p_time_end = $_POST['gio_ket_thuc'];
    $stmt->execute();
    $result = $stmt->get_result();
    $validate = $result->fetch_assoc();

    if($validate['result'] == 0){
        http_response_code(409);
        echo $exceptionTranslation["invalid_datetime"];
        return;
    }

    $keyStr = substr($keyStr, 0, -1).")";
    $createStr = substr($createStr, 0, -1).")";

    $types = str_repeat('s', count($valuesArr));

    $queryStr = "INSERT INTO `LICH_CHIEU`".$keyStr." values".$createStr;

    $stmt = $conn->prepare($queryStr);
    $stmt->bind_param($types, ...$valuesArr);
    $rs = $stmt->execute();
    
    if($rs){
        http_response_code(200);
        echo "Success";
    }else{
        http_response_code(500);
        // echo $exceptionTranslation["Error"];
        echo htmlspecialchars($stmt->error);
        // if(isset($exceptionTranslation[htmlspecialchars($stmt->error)])){
        //     echo $exceptionTranslation[htmlspecialchars($stmt->error)];
        // }else{
        //     echo $exceptionTranslation["Error"];
        // }
        // return;
    }
?>