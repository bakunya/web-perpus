<?php 

if(session_status() == PHP_SESSION_NONE) {session_start();}
  
  if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
    if (
        isset($_POST['email']) &&
        isset($_POST['alamat']) &&
        isset($_POST['nama']) &&
        isset($_POST['no']) &&
        isset($_POST['oldNo']) &&
        isset($_POST['telp']) &&
        isset($_POST['gender'])
    ) {
        include_once("../connection.php");

        $no = htmlspecialchars($_POST['no']);
        $oldNo = htmlspecialchars($_POST['oldNo']);
        $nama = htmlspecialchars($_POST['nama']);
        $gender = htmlspecialchars($_POST['gender']);
        $telp = htmlspecialchars($_POST['telp']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $email = htmlspecialchars($_POST['email']);

        
        $result = mysqli_query($mysqli, 
        "UPDATE 
            anggota
        SET 
            no_anggota = '$no', 
            nama = '$nama', 
            jk = '$gender', 
            telp = '$telp', 
            alamat = '$alamat', 
            email = '$email'
        WHERE
            no_anggota = $oldNo
        ");

        echo mysqli_error($mysqli);
        if (!mysqli_error($mysqli)) {
            echo "user successfully update";
            echo $result;
            $_SESSION['manage_user'] = "User berhasil di update.";
            header('Location: http://localhost/web-perpus/manage_users.php');
        }
    }
  } else {
    $_SESSION['masuk'] = false;
    header("Location: http://localhost/web-perpus/login.php");
  }
?>