<?php
    session_start();
    error_reporting(0);
    require("../../utils.php");
    _require_login();
    _require_not_client();
    _require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Quản lý user</title>
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
                    <li id="phim-name" class="breadcrumb-item active text-uppercase text-white">Quản lý user</li>
                </ol>
            </div>
            <div class="row phim-management">
                <h2 class="list-phim-heading mt-3 text-white">Danh sách users</h2>
                <div class="table-wrapper lich-table px-0 pt-3 col-12">
                    <table class="list-phim table table-striped table-bordered table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">SĐT</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require("../../api/User/UserGet.api.php");
                            $result = _get_list_user();
                            if ($result->num_rows > 0) {
                                while ($row =  $result->fetch_assoc()) { ?>
                                    <tr class="phim-item align-middle">
                                        <td scope="row"><?php echo $row['user_id']; ?></th>
                                        <td class="ten-phim-td"><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['ho_ten'] ?></td>
                                        <td><?php echo $row['sdt']; ?></td>
                                        <td>
                                            <button class="btn btn-danger user-delete-btn" data-toggle="modal" data-target="#phimDeleteModal" value="<?php echo $row['user_id'] ?>">Xóa</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else { 
                               echo '<tr><td colspan=5 class="phim-item align-middle text-center">Bảng chưa có dữ liệu<td></tr>';
                            
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User-delete-modal -->
    <div class="modal fade" id="phimDeleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc là muốn xóa <b>username</b> chứ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id='user-delete-confirm-btn'>Xác nhận</button>
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