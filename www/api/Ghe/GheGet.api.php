
<?php
    require_once '../../utils.php';

    /* 
    * Get list ghe empty in session
    * @return list ghe empty in session
    */
    function _get_empty_seat_by_session($session_id){
        $conn = connection();
        $stmt = $conn->prepare("CALL _get_empty_seat_in_specific_session(?)" );
        $stmt->bind_param("s", $session_id);
        $stmt->execute();
        $list_empty_seat = $stmt->get_result();

        return $list_empty_seat;
    }
    
    /* 
    * Get list seat
    * @return list seat
    */
    function _get_list_seats() {
        $conn = connection();
        $stmt = $conn->prepare("SELECT * from `GHE`, `PHONG_CHIEU` WHERE `PHONG_CHIEU`.`phong_chieu_id` = `GHE`.`phong_chieu_id` order by `GHE`.`phong_chieu_id` asc, `ghe_id` asc");
                                    
        $stmt->execute();
        $seats = $stmt->get_result();

        return $seats;
    }

    /* 
    * Get available room detail by phong_chieu_id
    * @return room detail
    */
    function _get_available_room() {
        $conn = connection();
        $stm = $conn->prepare("SELECT * FROM `PHONG_CHIEU`");

        $stm->execute();
        $result = $stm->get_result();

        return $result;
    }
?>