<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Đăng nhập</title>
</head>
<body>
    <div id="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-s-12">
                    <form id="login_form" class="login-form mx-auto px-4 pb-3 pt-5 rounded-lg shadow">
                        <h2 class="text-center text-white font-weight-bold">ĐĂNG NHẬP</h2>
                        <?php
                            if(isset($_GET["status"])){
                                if($_GET["status"] == "created")
                                echo "<div class='alert alert-info'> Sign up success </div>";
                            }
                        ?>
                        <div class="alert alert-danger" id="message_signin"></div>

                        <div class="form-group mt-4">
                            <label for="username" class="label-font text-white font-weight-bold">Tên tài khoản</label>
                            <input type="text" class="login-input form-control bg-transparent mt-1 text-white" placeholder="Hãy nhập tên tài khoản" id="username">
                        </div>
                
                        <div class="form-group mt-4">
                            <label for="password" class="label-font text-white font-weight-bold">Mật khẩu</label>
                            <input type="password" class="login-input form-control bg-transparent mt-1 text-white" placeholder="Hãy nhập mật khẩu" id="password">
                        </div>
            
                        <button type="submit" class="btn login-btn border-none text-white py-2 mb-3 mt-4" value="submit">ĐĂNG NHẬP</button>
            
                        <div class="forget-password text-right">
                            <a href="" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>
            
                        <div class="account mt-5 text-center">
                            Bạn chưa có tài khoản?
                            <a href="./Signup.php" class="text-decoration-none font-weight-bold">ĐĂNG KÝ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="/main.js"></script>
</body>
</html>
