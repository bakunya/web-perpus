<?php 
    include_once(dirname(__FILE__) . "/check_cookie.php");

    function check_login(){
        if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
            return true;
        } else {
            $cookie = CheckCookie();
            if ($cookie === true) {
                return true;
            } else {
                header("Location: http://localhost/web-perpus/login.php");
                return false;
            }
        }
    }

?>