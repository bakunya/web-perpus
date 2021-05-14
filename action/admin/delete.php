<?php 

    if(session_status() == PHP_SESSION_NONE) {session_start();}
    
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (isset($_POST['username'])) {
            include_once("../connection.php");

            $username = $_POST['username'];

            $result = mysqli_query($mysqli, 
            "DELETE FROM
                admin
            WHERE 
                username = '$username'
            ");

            echo "user successfully insert";
            echo mysqli_error($mysqli);
            if (!mysqli_error($mysqli)) {
                $_SESSION['manage_admin'] = "Admin berhasil di hapus.";
                header('Location: http://localhost/web-perpus/manage_admin.php');
            }
        }
    } else {
        $_SESSION['masuk'] = false;
        header("Location: http://localhost/web-perpus/login.php");
    }

?>