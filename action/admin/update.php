<?php 
if(session_status() == PHP_SESSION_NONE) {session_start();}

if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
    if (
        isset($_POST['username']) &&
        isset($_POST['oldUsername'])
    ) {
        $username = htmlspecialchars($_POST['username']);
        $oldUsername = htmlspecialchars($_POST['oldUsername']);
        include_once("../connection.php");
        
        if (isset($_POST['password']) && isset($_POST['oldPassword']) && $_POST['password'] !== '' && $_POST["oldPassword"] !== '') {
            $password = htmlspecialchars($_POST['password']);
            $oldPassword = htmlspecialchars($_POST['oldPassword']);

            if (strlen($password) < 6) {
                echo "Password harus panjang minimal 6 karakter";
            } else {
                $raw = mysqli_query($mysqli, "SELECT password FROM admin WHERE username = '$oldUsername'");
                $hash = mysqli_fetch_array($raw)[0];

                if (password_verify($oldPassword, $hash)) {
                    $options = [
                        'cost' => 12
                    ];
                    $hashing = password_hash($password, PASSWORD_BCRYPT, $options);

                    $result = mysqli_query($mysqli, 
                    "UPDATE admin 
                        SET 
                            password = '$hashing'
                        WHERE 
                            username = '$oldUsername'
                    ");

                    echo "user gagal update <br />";
                    echo mysqli_error($mysqli);
                    if (!mysqli_error($mysqli)) {
                        $_SESSION['manage_admin'] = "Admin berhasil di update.";
                        header('Location: http://localhost/web-perpus/manage_admin.php');
                    }
                } else {
                    echo "password salah";
                }
            }

        } else {
            $result = mysqli_query($mysqli, 
            "UPDATE admin 
                SET
                    username = '$username'
                WHERE username = '$oldUsername'
            ");

            echo "user gagal update";
            echo mysqli_error($mysqli);
            if (!mysqli_error($mysqli)) {
                $_SESSION['manage_admin'] = "Admin berhasil di update.";
                header('Location: http://localhost/web-perpus/manage_admin.php');
            }
        }
    }  
}


?>