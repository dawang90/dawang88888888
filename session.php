<?php
    session_start();
    include ('conn.php');
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "select * from users where email='{$email}'";
    $result = $DB -> query_first($sql);

    if($result){
        if($result['password'] == $pass){
            $_SESSION['login_status'] = 1;
            echo '登录成功!';
        }else{
            echo "密码错误!";
        }
    }else{
        echo "帐号不存在!";
    }

?>