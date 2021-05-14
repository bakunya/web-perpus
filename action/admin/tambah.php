<?php 
    if(session_status() == PHP_SESSION_NONE) {session_start();}
    
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (
           isset( $_POST['username']) &&
           isset( $_POST['password'])
        ) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $token= uniqid($prefix = time(), $more_entropy = true);
    
            if (strlen($password) < 7) {
                echo "Password harus panjang minimal 6 karakter";
            } else {
                include_once("../connection.php");
                $options = [
                    'cost' => 12
                ];
                $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    
                $result = mysqli_query($mysqli, 
                "INSERT 
                    INTO admin(username, password, token)
                    VALUES ('$username', '$hash', '$token')
                ");
    
                echo "user successfully insert";
                echo mysqli_error($mysqli);
                if (!mysqli_error($mysqli)) {
                    $_SESSION['manage_admin'] = "Admin berhasil di tambah.";
                    header('Location: http://localhost/web-perpus/manage_admin.php');
                }
            }
        }
    } else {
        $_SESSION['masuk'] = false;
        header("Location: http://localhost/web-perpus/login.php");
    }

?>