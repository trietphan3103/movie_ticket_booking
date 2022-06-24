<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
    ];

    $attrArr = array();
    $valuesArr = array();
    $keyStr = "(";
    $createStr = " (";

    // Init default value
    $_POST["created_by"] = _get_current_user_id();
    $_POST["owner"] = _get_current_user_id();

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

    $keyStr = substr($keyStr, 0, -1).")";
    $createStr = substr($createStr, 0, -1).")";

    $types = str_repeat('s', count($valuesArr));

    $queryStr = "INSERT INTO `VE_PHIM`".$keyStr." values".$createStr;

    $stmt = $conn->prepare($queryStr);
    $stmt->bind_param($types, ...$valuesArr);
    $rs = $stmt->execute();
    
    if($rs){
        http_response_code(200);
        echo "Success";
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