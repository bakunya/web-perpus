<?php 
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if(session_status() == PHP_SESSION_NONE) {session_start();}

        include_once("../connection.php");
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $mysql_res = mysqli_query($mysqli, 
        "SELECT * FROM 
            admin
         WHERE 
            username = '$username'"
        );

        if (!mysqli_error($mysqli)) {
            $admin = mysqli_fetch_array($mysql_res);
            if ($admin !== null && count($admin) >= 2) {
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['username'] = $admin['username'];
                    $_SESSION['masuk'] = true;
                    setcookie("token", $admin['token'], time() + (60*60*24*3), "/", null, false, true);
                    setcookie("username", $admin['username'], time() + (60*60*24*3), "/", null, false, true);
                    header("Location: http://localhost/web-perpus/pinjam.php");
                } else {
                    $_SESSION['masuk'] = false;
                    $_SESSION['auth_error'] = "Maaf, username tidak terdaftar.";
                    header("Location: http://localhost/web-perpus/login.php");
                }    
            } else {
                session_unset();
                $_SESSION['masuk'] = false;
                $_SESSION['auth_error'] = "Maaf, username tidak terdaftar.";
                header("Location: http://localhost/web-perpus/login.php");
            }  
        } else {
            echo mysqli_error($mysqli);
            session_unset();
            $_SESSION['masuk'] = false;
            $_SESSION['auth_error'] = "Ups, something broke...";
            header("Location: http://localhost/web-perpus/login.php");
        }
    } else {
        session_unset();
        $_SESSION['masuk'] = false;
        $_SESSION['auth_error'] = "Masukan username dan password...";
        header("Location: http://localhost/web-perpus/login.php");
    }

?>