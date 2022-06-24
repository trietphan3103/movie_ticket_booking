
<?php
    require_once '../../utils.php';

    /* 
    * Get list LICH_CHIEU
    * @return list LICH_CHIEU
    */
    function _get_list_session(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT `LICH_CHIEU`.*, `USERS`.`user_name` as 'creator', `PHONG_CHIEU`.`ten_phong`, `PHIM`.`ten_phim`
                                FROM `LICH_CHIEU`, `USERS`, `PHONG_CHIEU`, `PHIM`
                                WHERE `LICH_CHIEU`.`gio_bat_dau` >= NOW()
                                and `LICH_CHIEU`.`created_by` = `USERS`.`user_id`
                                and `LICH_CHIEU`.`phong_chieu_id`= `PHONG_CHIEU`.`phong_chieu_id`
                                and  `LICH_CHIEU`.`phim_id` = `PHIM`.`phim_id`
                                order by `LICH_CHIEU`.`gio_bat_dau` desc" );
        $stmt->execute();
        $lich_chieu_list = $stmt->get_result();

        return $lich_chieu_list;
    }

    /* 
    * Get list LICH_CHIEU by film
    * @return list LICH_CHIEU of a film
    */
    function _get_list_session_by_film_id($p_film_id){
        $conn = connection();
        $stmt = $conn->prepare("SELECT `LICH_CHIEU`.*, `USERS`.`user_name` as 'creator', `PHONG_CHIEU`.`ten_phong`, `PHIM`.`ten_phim`, DATE(`LICH_CHIEU`.`gio_bat_dau`) as `ngay_chieu`, TIME(`LICH_CHIEU`.`gio_bat_dau`) as `gio_chieu`
                                FROM `LICH_CHIEU`, `USERS`, `PHONG_CHIEU`, `PHIM`
                                WHERE `LICH_CHIEU`.`gio_bat_dau` >= NOW()
                                and `LICH_CHIEU`.`phim_id` = ?
                                and `LICH_CHIEU`.`created_by` = `USERS`.`user_id`
                                and `LICH_CHIEU`.`phong_chieu_id`= `PHONG_CHIEU`.`phong_chieu_id`
                                and  `LICH_CHIEU`.`phim_id` = `PHIM`.`phim_id`
                                order by `LICH_CHIEU`.`gio_bat_dau` desc");
        $stmt->bind_param("s", $p_film_id);
        $stmt->execute();
        $lich_chieu_list = $stmt->get_result();
        
        return $lich_chieu_list;
    }

    /* 
    * Get distinct list LICH_CHIEU by film
    * @return list LICH_CHIEU of a film
    */
    function _get_list_session_by_film_id_distinct_by_date($p_film_id){
        $conn = connection();
        $stmt = $conn->prepare("SELECT DISTINCT DATE(`LICH_CHIEU`.`gio_bat_dau`) as `ngay_chieu`
                                FROM `LICH_CHIEU`, `USERS`, `PHONG_CHIEU`, `PHIM`
                                WHERE `LICH_CHIEU`.`gio_bat_dau` >= NOW()
                                and `LICH_CHIEU`.`phim_id` = ?
                                and `LICH_CHIEU`.`created_by` = `USERS`.`user_id`
                                and `LICH_CHIEU`.`phong_chieu_id`= `PHONG_CHIEU`.`phong_chieu_id`
                                and  `LICH_CHIEU`.`phim_id` = `PHIM`.`phim_id`
                                order by DATE(`LICH_CHIEU`.`gio_bat_dau`) desc");
        $stmt->bind_param("s", $p_film_id);
        $stmt->execute();
        $lich_chieu_list = $stmt->get_result();
        
        return $lich_chieu_list;
    }

        /* 
    * Get list LICH_CHIEU by film and date start
    * @return list LICH_CHIEU of a film and date start
    */
    function _get_list_session_by_film_id_and_date_start($p_film_id, $p_date_start){
        $conn = connection();
        $stmt = $conn->prepare("SELECT `LICH_CHIEU`.*, `USERS`.`user_name` as 'creator', `PHONG_CHIEU`.`ten_phong`, `PHIM`.`ten_phim`, DATE(`LICH_CHIEU`.`gio_bat_dau`) as `ngay_chieu`, TIME(`LICH_CHIEU`.`gio_bat_dau`) as `gio_chieu`, TIME(`LICH_CHIEU`.`gio_ket_thuc`) as `gio_chieu_xong`
                                FROM `LICH_CHIEU`, `USERS`, `PHONG_CHIEU`, `PHIM`
                                WHERE `LICH_CHIEU`.`gio_bat_dau` >= NOW()
                                and `LICH_CHIEU`.`phim_id` = ?
                                and DATE(`LICH_CHIEU`.`gio_bat_dau`) = DATE(?)
                                and `LICH_CHIEU`.`created_by` = `USERS`.`user_id`
                                and `LICH_CHIEU`.`phong_chieu_id`= `PHONG_CHIEU`.`phong_chieu_id`
                                and  `LICH_CHIEU`.`phim_id` = `PHIM`.`phim_id`
                                order by `LICH_CHIEU`.`gio_bat_dau` desc");
        $stmt->bind_param("ss", $p_film_id, $p_date_start);
        $stmt->execute();
        $lich_chieu_list = $stmt->get_result();
        
        return $lich_chieu_list;
    }

    
?>