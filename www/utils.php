<?php
    session_start();
    error_reporting(0);
    // Hàm tạo connection tới DB
    function connection(){
        $host = 'mysql-server'; // tên mysql server
        $user = 'root';
        $pass = 'root';
        $db = 'BANANA_CINEMA'; // tên databse

        $conn = new mysqli($host, $user, $pass, $db);
        $conn->set_charset("utf8");
        if ($conn->connect_error) {
            die('Không thể kết nối database: ' . $conn->connect_error);
        }

       return $conn;
    }

    // Hàm lấy url hiện tại
    function current_url(){
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $validURL = str_replace("&", "&amp;", $url);
        return $validURL;
    }

    // Function return encoded password
    function _encode_password($pass_word){
        $options = [
            'cost' => 12,
        ];

        return password_hash($pass_word, PASSWORD_BCRYPT, $options);
    }

    // Function get current user name
    function _get_current_user(){
        return $_SESSION["username"];
    }

    // Function get current user id
    function _get_current_user_id(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT `USERS`.`user_id`FROM `USERS`WHERE `USERS`.`user_name` = ?");
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION["username"];
        $stmt->execute();
        $result = $stmt->get_result();

        $user_info = $result->fetch_assoc();

        return $user_info['user_id'];
    }

    // Function to valide params type string not null
    function _validate_not_null($str){
        return isset($str) && strlen($str) > 0;
    }

    // Function to validate user is login or not
    function _check_user_logged(){
        return _validate_not_null($_SESSION["username"]);
    }

    // Function require user login
    function _require_login(){
        if(!_check_user_logged()){
            header('Location: /view/utilsView/Login.php');
            exit;
        }
    }

    // Function check user have role employee
    function _check_employee(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT 1 as result FROM `USERS`, `USER_ROLE`  WHERE `USERS`.`user_name` = ? and `USER_ROLE`.`role_id` = 3 and `USERS`.`user_id` = `USER_ROLE`.`user_id`");
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION["username"];
        $stmt->execute();
        $result = $stmt->get_result();
        
        return mysqli_num_rows($result) > 0;
    }

    // Function check user have role admin
    function _check_admin(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT 1 as result FROM `USERS`, `USER_ROLE`  WHERE `USERS`.`user_name` = ? and `USER_ROLE`.`role_id` = 1 and `USERS`.`user_id` = `USER_ROLE`.`user_id`");
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION["username"];
        $stmt->execute();
        $result = $stmt->get_result();
        
        return mysqli_num_rows($result) > 0;
    }

    // Function check user have role client
    function _check_client(){
        $conn = connection();
        $stmt = $conn->prepare("SELECT 1 as result FROM `USERS`, `USER_ROLE`  WHERE `USERS`.`user_name` = ? and `USER_ROLE`.`role_id` = 2 and `USERS`.`user_id` = `USER_ROLE`.`user_id`");
        $stmt->bind_param("s", $user_name);
        $user_name = $_SESSION["username"];
        $stmt->execute();
        $result = $stmt->get_result();
        
        return mysqli_num_rows($result) > 0;
    }

    // Function require admin role
    function _require_admin(){
        if(!_check_admin()){
            header("Location: /view/utilsView/Error403.html");
        }
    }

    // Function require not client
    function _require_not_client(){
        if(_check_client()){
            header("Location: /view/utilsView/Error403.html");
        }
    }
?>
