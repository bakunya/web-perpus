<?php 
    if(session_status() == PHP_SESSION_NONE) {session_start();}
    session_destroy();
    setcookie("username", "", time() + 1, "/", null, false, true);
    setcookie("token", "", time() + 1, "/", null, false, true);
    header("Location: http://localhost/web-perpus/login.php")

?>