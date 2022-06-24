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
?>
