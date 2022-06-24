<?php
    require('../../utils.php');
    require_once '../../api/Product/ProductGet.api.php';

    $result = _getPhimDetail($_GET["phim-id"]);
    if ($result->num_rows > 0) {
        while($row =  $result->fetch_assoc()) {
            printf("Thông tin chi tiết phim: id: %s, tên: %s, time: %s, description: %s\n", $row['phim_id'], $row['ten_phim'], $row['mo_ta'], $row['thoi_luong']);  
        }
	}
	else {
		printf("Bảng chưa có dữ liệu");
	}
?>