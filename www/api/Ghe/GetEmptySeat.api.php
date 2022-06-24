<?php
    require_once '../../utils.php';
    require_once './GheGet.api.php';

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
    ];

    if(isset($_GET['session_id'])){
        $conn = connection();
        $list_empty_seat = _get_empty_seat_by_session($_GET['session_id']);
        $arr_rs = [];
        while ($seat =  $list_empty_seat->fetch_assoc()) {
            $arr_rs[] = $seat;
        }
        echo json_encode($arr_rs);
        return;
    } else {
        http_response_code(422);
        echo $exceptionTranslation['Empty field'];
        return;
    }
?>
