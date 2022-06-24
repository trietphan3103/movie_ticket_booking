<?php
    require_once '../../utils.php';
    $conn = connection();

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
        "permission" => "Bạn không đủ quyền hạn để thực hiện thao tác này",
    ];

    if(!_check_admin()){
        echo $exceptionTranslation['permission'];
        return;
    }

    if(isset($_POST['user_id'])){
        // Check existed user
        $stmt = $conn->prepare("SELECT * FROM `USERS` WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $user_id = $_POST['user_id'];
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) == 0) {
            http_response_code(404);
            echo "Tài khoản không tồn tại";
            return; 
        }
    }

   
    $queryStr = "UPDATE `USERS` SET `USERS`.`active` = 0 WHERE `USERS`.`user_id` = ?";

    $stmt = $conn->prepare($queryStr);
    $stmt->bind_param("s", $user_id);
    $user_id = $_POST['user_id']; 
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