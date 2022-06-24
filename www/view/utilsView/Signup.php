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
    <title>Đăng ký tài khoản</title>
</head>
<body>
    <div id="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-s-12">
                    <form  id="sign_up_form" class="login-form mx-auto px-4 pb-3 pt-5 rounded-lg shadow">
                        <h2 class="text-center text-white font-weight-bold">ĐĂNG KÝ TÀI KHOẢN</h2>
                        <div class="alert alert-danger" id="message_signup"></div>
                        <div class="form-group mt-4">                                                                                                                                                                                                                                                                                                                                                                                   
                            <label for="username" class="label-font text-white font-weight-bold">Tên tài khoản</label>
                            <input name="username" type="text" class="login-input form-control bg-transparent mt-1 text-white" placeholder="Hãy nhập tên tài khoản" id="username">
                        </div>
                
                        <div class="form-group mt-4">
                            <label for="password" class="label-font text-white font-weight-bold">Mật khẩu</label>
                            <input name="password" type="password" class="login-input form-control bg-transparent mt-1 text-white" placeholder="Hãy nhập mật khẩu" id="password">
                        </div>
            
                        <div class="form-group mt-4">
                            <label for="confirm-password" class="label-font text-white font-weight-bold">Xác nhận mật khẩu</label>
                            <input name="confirm-password" type="password" class="login-input form-control bg-transparent mt-1 text-white" placeholder="Hãy nhập mật khẩu" id="confirm-password">
                        </div>
            
                        <button type="submit" class="btn login-btn border-none text-white py-2 mb-3 mt-4" value="submit">ĐĂNG KÝ</button>
            
                        <div class="account mt-5 text-center">
                            Đã có tài khoản?
                            <a href="./Login.php" class="text-decoration-none font-weight-bold">ĐĂNG NHẬP</a>
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
