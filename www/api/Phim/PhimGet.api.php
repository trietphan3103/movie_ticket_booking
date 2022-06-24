<?php
    /* 
    * Get Detail of one product base on specific id
    * @param id
    * @return product detail
    */
    function _getPhimDetail($id){
        $conn = connection();
        $stm = $conn->prepare("SELECT * from PHIM where phim_id=?");

        // $id = $_GET['id'];

        $stm->bind_param('i', $id);
        $stm->execute();
        $result = $stm->get_result();
        
        return $result;
    }

    /* 
    * Get list product
    * @return list product detail
    */
    function _getListPhim(){
        $conn = connection();
        $sql = "SELECT * from PHIM order by phim_id desc";
        $result = $conn->query($sql);

        return $result;
    }

    // get list phim đang chiếu 
    function _getListPhimDangChieu(){
        $conn = connection();
        $sql = "SELECT * FROM `PHIM` WHERE phim_id in (select phim_id from `LICH_CHIEU` where gio_bat_dau > CURRENT_TIMESTAMP and  DATE(gio_bat_dau) = CURDATE()) order by ngay_phat_hanh desc";
        $result = $conn->query($sql);

        return $result;
    }

    // get list phim sắp chiếu 
    function _getListPhimSapChieu(){
        $conn = connection();
        $sql = "SELECT * FROM `PHIM` WHERE phim_id in (select phim_id from `LICH_CHIEU` where DATE(gio_bat_dau) > CURDATE()) order by ngay_phat_hanh desc";
        $result = $conn->query($sql);

        return $result;
    }

    // get list phim for side bar
    function _getSidebarPhim($id){
        $conn = connection();
        $stm = $conn->prepare("SELECT * from PHIM where phim_id != ? and ngay_phat_hanh <= CURDATE() order by ngay_phat_hanh desc limit 3");

        // $id = $_GET['id'];

        $stm->bind_param('i', $id);
        $stm->execute();
        $result = $stm->get_result();
        
        return $result;
    }

    function _getPosterDoc($id){
        $conn = connection();
        $stm = $conn->prepare("SELECT * from IMAGES where phim_id=? and the_loai = '0'");

        $stm->bind_param('i', $id);
        $stm->execute();
        $result = $stm->get_result();
        
        return $result;
    }

    function _getPosterNgang($id){
        $conn = connection();
        $stm = $conn->prepare("SELECT * from IMAGES where phim_id=? and the_loai = '1'");

        $stm->bind_param('i', $id);
        $stm->execute();
        $result = $stm->get_result();
        
        return $result;
    }
?>
