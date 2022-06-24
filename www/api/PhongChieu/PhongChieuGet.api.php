<?php
    require_once '../../utils.php';

    /* 
    * Get list rooms
    * @return list rooms
    */
    function _get_list_rooms() {
        $conn = connection();
        $stmt = $conn->prepare("SELECT * from `PHONG_CHIEU` order by phong_chieu_id asc");
                                    
        $stmt->execute();
        $rooms = $stmt->get_result();

        return $rooms;
    }

    /* 
    * Get room detail by phong_chieu_id
    * @return room detail
    */
    function _get_room_detail($id) {
        $conn = connection();
        $stm = $conn->prepare("SELECT * from `PHONG_CHIEU` where phong_chieu_id = ?");

        $stm->bind_param('i', $id);
        $stm->execute();
        $result = $stm->get_result();
        
        return $result;
    }
?>
