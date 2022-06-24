<?php  
    session_start();
    error_reporting(0);
    require("../../utils.php");
    require("../../api/Phim/PhimGet.api.php");
    _require_login();
    _require_not_client();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Quản lý phim</title>
</head>

<body>
    <?php
        include("../Common/Header.php");
    ?>

    <div id="lich-management-wrapper">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb mb-4 list-unstyled">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-decoration-none">Trang chủ</a>
                    </li>
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Quản lý phim</li>
                </ol>
            </div>
            <div class="add-lich-chieu__btn">
                <div class="btn_contain" href="#" data-toggle="modal" data-target="#phimCreateModal">
                    <label>Thêm phim mới</label>
                    <i class="fas fa-plus-circle add_btn"></i>
                </div>
            </div>
            <div class="row phim-management">
                <h2 class="list-phim-heading text-white">Danh sách phim</h2>
                <div class="table-wrapper lich-table px-0 pt-3 col-12">
                    <table class="list-phim table table-striped table-bordered table-hover table-dark">
                        <?php
                            if(isset($_GET["status"])){
                                if($_GET["status"] == "created")
                                    echo '<div class="alert alert-info"> Thêm phim mới thành công </div>';
                                if($_GET["status"] == "deleted")
                                    echo '<div class="alert alert-info"> Xóa phim thành công </div>';
                            }
                        ?>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên phim</th>
                                <th scope="col">Ngày phát hành</th>
                                <th scope="col">Thời lượng</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = _getListPhim();
                            if ($result->num_rows > 0) {
                                while ($row =  $result->fetch_assoc()) { ?>
                                    <tr class="phim-item align-middle">
                                        <th scope="row"><?php echo $row['phim_id']; ?></th>
                                        <td class="ten-phim-td"><?php echo $row['ten_phim']; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($row['ngay_phat_hanh'])); ?></td>
                                        <td><?php echo $row['thoi_luong']; ?></td>
                                        <td><a href="/view/Phim/PhimManagementDetail.php?phim-id=<?php echo $row['phim_id'] ?>">
                                                <button class="btn btn-primary phim-view-detail-btn user-modify-btn">Xem Chi Tiết</button>
                                            </a>
                                            <button class="btn btn-danger phim-delete-btn user-delete-btn" data-toggle="modal" data-target="#phimDeleteModal" value="<?php echo $row['phim_id'] ?>">Xóa</button>
                                            <button class="btn btn-success phim-update-btn user-edit-btn" data-toggle="modal" data-target="#phimUpdateModal" value="<?php echo $row['phim_id'] ?>">Sửa</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else { ?>
                                <h1>Bảng chưa có dữ liệu</h1>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Phim Create Modal -->
    <div class="phim-create-modal modal fade" id="phimCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tạo phim mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="phim-create-form">
                        <div class="custom-file mb-3 phim-poster-doc">
                            <img id="phim-poster-doc-img-input" src="#" alt="your image" style="width:100%" />
                            <input accept="image/*" type="file" name="poster_doc" class="custom-file-input form-control" id="phim-poster-doc-input">
                            <label class="custom-file-label"  for="phim-poster-doc-input">Chọn poster dọc cho phim</label>
                        </div>
                        <div class="custom-file mb-3 phim-poster-ngang">
                            <img id="phim-poster-ngang-img-input" src="#" alt="your image" style="width:100%" />
                            <input accept="image/*" type="file" name="poster_ngang" class="custom-file-input form-control" id="phim-poster-ngang-input">
                            <label class="custom-file-label" for="phim-poster-ngang-input">Chọn poster ngang cho phim</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-name-input">Tên Phim</label>
                                <input type="text" class="form-control" id="phim-name-input" placeholder="Nhập tên phim...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-nsx-input">Nhà sản xuất</label>
                                <input type="text" class="form-control" id="phim-nsx-input" placeholder="Nhập tên nhà sản xuất...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-nation-input">Quốc gia</label>
                                <input type="text" class="form-control" id="phim-nation-input" placeholder="Nhập tên quốc gia...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-actor-input">Diễn viên</label>
                                <input type="text" class="form-control" id="phim-actor-input" placeholder="Nhập tên diễn viên...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-director-input">Đạo diễn</label>
                                <input type="text" class="form-control" id="phim-director-input" placeholder="Nhập tên đạo diễn...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-type-input">Thể loại</label>
                                <input type="text" class="form-control" id="phim-type-input" placeholder="Nhập thể loại phim...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-ngay-phat-hanh-input">Ngày phát hành</label>
                                <input type="date" class="form-control" id="phim-ngay-phat-hanh-input" placeholder=NOW()>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-time-input">Thời lượng</label>
                                <input type="number" class="form-control" id="phim-time-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phim-mo-ta-input">Nội dung phim</label>
                            <textarea rows="4" type="text" class="form-control" id="phim-mo-ta-input" placeholder="Nhập nội dung phim"></textarea>
                        </div>
                        <div class="alert alert-danger" role="alert" id="message_create_phim"></div>
                        <div class="form-footer">
                            <button type="reset" class="btn btn-outline-primary phim-clear-btn">Clear</button>
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Phim Update Modal -->
    <div class="phim-update-modal modal fade" id="phimUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh sửa phim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="phim-update-form">
                        <div class="custom-file mb-3 phim-poster-doc">
                            <img id="phim-poster-doc-img-update" src="#" alt="your image" style="width:100%" />
                            <input accept="image/*" type="file" name="poster_doc" class="custom-file-input form-control" id="phim-poster-doc-update">
                            <label class="custom-file-label" for="phim-poster-doc-update">Chọn poster dọc cho phim</label>
                        </div>
                        <div class="custom-file mb-3 phim-poster-ngang">
                            <img id="phim-poster-ngang-img-update" src="#" alt="your image" style="width:100%" />
                            <input accept="image/*" type="file" name="poster_ngang" class="custom-file-input form-control" id="phim-poster-ngang-update">
                            <label class="custom-file-label" for="phim-poster-ngang-update">Chọn poster ngang cho phim</label>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-name-update">Tên Phim</label>
                                <input type="text" class="form-control" id="phim-name-update" placeholder="Nhập tên phim...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-nsx-update">Nhà sản xuất</label>
                                <input type="text" class="form-control" id="phim-nsx-update" placeholder="Nhập tên nhà sản xuất...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-nation-update">Quốc gia</label>
                                <input type="text" class="form-control" id="phim-nation-update" placeholder="Nhập tên quốc gia...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-actor-update">Diễn viên</label>
                                <input type="text" class="form-control" id="phim-actor-update" placeholder="Nhập tên diễn viên...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-director-update">Đạo diễn</label>
                                <input type="text" class="form-control" id="phim-director-update" placeholder="Nhập tên đạo diễn...">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-type-update">Thê loại</label>
                                <input type="text" class="form-control" id="phim-type-update" placeholder="Nhập thể loại phim...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="phim-ngay-phat-hanh-update">Ngày phát hành</label>
                                <input type="date" class="form-control" id="phim-ngay-phat-hanh-update" placeholder=NOW()>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phim-time-update">Thời lượng</label>
                                <input type="number" class="form-control" id="phim-time-update">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phim-mo-ta-update">Nội dung phim</label>
                            <textarea rows="4" type="text" class="form-control" id="phim-mo-ta-update" placeholder="Nhập nội dung phim"></textarea>
                        </div>
                        <div class="alert alert-danger" role="alert" id="message_update_phim"></div>
                        <div class="form-footer">
                            <button type="reset" class="btn btn-outline-primary phim-clear-btn">Clear</button>
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Phim-delete-modal -->
    <div class="modal fade" id="phimDeleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa phim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc là muốn xóa <b>username</b> chứ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id='phim-delete-confirm-btn'>Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("../Common/Footer.php");
    ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>

</html>