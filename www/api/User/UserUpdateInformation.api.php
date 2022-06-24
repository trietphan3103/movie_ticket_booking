<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Incorrect date value: '' for column 'ngay_sinh' at row 1" => "Ngày sinh là thông tin bắt buộc",
        "sdt length condition" => "Số điện thoại phải có 10 chữ số",
        "sdt used" => "Số điện thoại đã được đăng ký",
        "cmnd used" => "Số  chứng minh nhân dân đã được đăng ký",
        "Empty field" => "Vui lòng điền đầy đủ các thông tin",
    ];

    if(_validate_not_null($_POST['sdt'])){
        if(strlen($_POST['sdt']) != 10){
            http_response_code(422);
            echo $exceptionTranslation["sdt length condition"];
            return;
        }    
    }

    // Check existed sdt
    $stmt = $conn->prepare("SELECT * FROM `USERS` WHERE sdt = ? and user_name != ?");
    $stmt->bind_param("ss", $sdt, $user_name);
    $sdt = $_POST['sdt'];
    $user_name = _get_current_user();
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0 ) {
        http_response_code(409);
        echo $exceptionTranslation["sdt used"];
        return; 
    }

    // Check existed cmnd
    if(_validate_not_null($_POST['cmnd'])){
        $stmt = $conn->prepare("SELECT * FROM `USERS` WHERE cmnd = ? and user_name != ?");
        $stmt->bind_param("ss", $cmnd, $user_name);
        $cmnd = $_POST['cmnd'];
        $user_name = _get_current_user();
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0 ) {
            http_response_code(409);
            echo $exceptionTranslation["cmnd used"];
            return; 
        }
    }

    $attrArr = array();
    $valuesArr = array();
    $updateStr = " SET";

    foreach ($_POST as $key => $value){
        if(!_validate_not_null($value)){
            http_response_code(422);
            echo $exceptionTranslation["Empty field"];
            return;
        }
        
        array_push($attrArr, $key);
        array_push($valuesArr, $value);
        $updateStr = $updateStr." ".$key."= ?,";
    }

    array_push($valuesArr, $_SESSION["username"]);
    $updateStr = substr($updateStr, 0, -1);

    $types = str_repeat('s', count($valuesArr));

    $queryStr = "UPDATE USERS ".$updateStr." WHERE user_name = ?";

    $stmt = $conn->prepare($queryStr);
    $stmt->bind_param($types, ...$valuesArr);
    $stmt->execute();
    $rs = $stmt->execute();
    
    if($rs){
        http_response_code(200);
        echo "Success";
        return;
    }else{
        http_response_code(500);
        // echo $exceptionTranslation["Error"];
        echo htmlspecialchars($stmt->error);
        return;
    }
?>