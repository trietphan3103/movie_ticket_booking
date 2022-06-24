<?php
  session_start();
  // require_once("../../utils.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="/style.css"> <!-- Sử dụng link tuyệt đối tính từ root, vì vậy có dấu / đầu tiên -->
  <title>Header</title>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-transparent">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1 class="text-light"><a href="/"><span>Banana Cinema</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link " href="/">Trang chủ</a></li>
          <li><a class="nav-link" href="/view/Phim/PhimList.php">Phim</a></li>
          <!-- <li><a class="nav-link" href="#">Góc điện ảnh</a></li>
          <li><a class="nav-link" href="#">Sự kiện</a></li>
          <li><a class="nav-link" href="#">Hỗ trợ</a></li> -->
          
          <?php
          if(!_check_client() && _check_user_logged()){
            echo '<li class="dropdown">
            <a href="#">Quản lý
                <i class="dropdown-icon fas fa-chevron-down"></i>
                <i class="dropdown-icon-mobile fas fa-chevron-right"></i> 
            </a>
            <ul>';
                    if(_check_employee() || _check_admin()){
                        echo '<li><a href="/view/Phim/PhimManagement.php">Quản lý phim</a></li>';
                        echo '<li><a href="/view/LichChieu/LichChieuManagement.php">Quản lý lịch chiếu</a></li>';
                        echo '<li><a href="/view/PhongChieu/PhongChieuManagement.php">Quản lý phòng chiếu</a></li>';
                        echo '<li><a href="/view/Ghe/GheManagement.php">Quản lý ghế</a></li>';
                    }

                    if(_check_admin()){
                        echo '<li><a href="/view/Users/UserManagement.php">Quản lý user</a></li>';
                    }
   
            echo '</ul></li>';
          }
            
          ?>
          <?php if(isset($_SESSION["username"])):?>
              <li class="dropdown">
                  <a class="nav-link scrollto account" href="#"> <i class="fas fa-user-circle"></i> &nbsp &nbsp  <?php echo $_SESSION["username"]?></a>
                  <ul class="account-dropdown">
                    <li><a href="/view/Users/UserDetail.php">User detail</a></li>
                    <li class="logout-btn"><a href="/view/utilsView/Logout.php"> Log out</a></li>
                  </ul>
              </li>
          <?php else: ?>
            <li class=""><a class="nav-link login-btn" href="/view/utilsView/Login.php">Login</a></li>
          <?php endif; ?>
        </ul>
        <i class="fas fa-bars mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header --> 
</body>

</html>