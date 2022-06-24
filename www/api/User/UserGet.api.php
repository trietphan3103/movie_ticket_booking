
<?php
    require_once '../../utils.php';

    /* 
    * Get user information by username in session
    * @return user information
    */
    function _get_user_information(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT * FROM `USERS` WHERE user_name = ?");
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION['username'];
        $stmt->execute();
        $result = $stmt->get_result();

        $user_info = $result->fetch_assoc();

        return $user_info;
    }

    /* 
    * Get current user's ticket
    * @return user's ticket
    */
    function _get_user_tickets(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT `VE_PHIM`.*, `PHIM`.`ten_phim`, `LICH_CHIEU`.`gio_bat_dau`, `LICH_CHIEU`.`gio_ket_thuc`, `PHONG_CHIEU`.`ten_phong` 
                                FROM `VE_PHIM`, `USERS` , `PHIM`, `LICH_CHIEU`, `PHONG_CHIEU`
                                WHERE owner = `USERS`.`user_id` and `USERS`.`user_name` = ?
                                and `LICH_CHIEU`.`lich_chieu_id` = `VE_PHIM`.`lich_chieu_id`
                                and `LICH_CHIEU`.`phim_id` = `PHIM`.`phim_id`
                                and `LICH_CHIEU`.`phong_chieu_id` = `PHONG_CHIEU`.`phong_chieu_id`");
                                    
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION['username'];
        $stmt->execute();
        $tickets = $stmt->get_result();

        return $tickets;
    }

    /* 
    * Get list user
    * @return list user
    */

    function _get_list_user(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT * FROM `USERS` where active = 1 and user_id != 1");
        $stmt->execute();
        $user_list = $stmt->get_result();

        return $user_list;
    }
?>