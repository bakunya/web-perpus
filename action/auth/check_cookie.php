<?php
    
    function CheckCookie()
    {
        if (isset($_COOKIE['username']) && isset($_COOKIE['token'])) {
            include_once(dirname(__FILE__). "/../connection.php");
            $username = $_COOKIE['username'];
            $currToken = mysqli_fetch_array(mysqli_query($mysqli, "SELECT token FROM admin WHERE username = '$username'"))['token'];
            if ($currToken === $_COOKIE['token']) {
                $_SESSION['masuk'] = true;
                $_SESSION['username'] = $username;
                $token = uniqid($prefix = time(), $more_entropy = true);
                setcookie("username", $username, time() + (60*60*24*3), "/", null, false, true);
                setcookie("token", $token, time() + (60*60*24*3), "/", null, false, true);
                mysqli_query($mysqli, "UPDATE admin SET token = '$token' WHERE username = '$username'");
                echo mysqli_error($mysqli);
                if (mysqli_error($mysqli)) {
                    return false;
                } else {
                    return true;
                }
            } else {
                $_SESSION['masuk'] = false; 
                return false;
            }
        } else {
            $_SESSION['masuk'] = false;
            return false;
        }
    }

?>