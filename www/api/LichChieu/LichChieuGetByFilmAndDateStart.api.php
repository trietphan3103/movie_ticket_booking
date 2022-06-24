<?php
    require_once '../../utils.php';
    require_once './LichChieuGet.api.php';

    $exceptionTranslation = [
        "Error" => "Có lỗi đã xảy ra, vui lòng thử lại lần nữa",
        "Empty field" => "Vui lòng điền đầy đủ thông tin",
    ];

    if(isset($_GET['phim_id']) && isset( $_GET['date_start'])){
        $conn = connection();
        $list_session = _get_list_session_by_film_id_and_date_start($_GET['phim_id'], $_GET['date_start']);
        $arr_rs = [];
        while ($session =  $list_session->fetch_assoc()) {
            $arr_rs[] = $session;
        }
        echo json_encode($arr_rs);
        return;
    } else {
        http_response_code(422);
        echo $exceptionTranslation['Empty field'];
        return;
    }
?>
