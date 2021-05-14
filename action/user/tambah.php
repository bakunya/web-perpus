<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (
            isset($_POST['email']) &&
            isset($_POST['alamat']) &&
            isset($_POST['nama']) &&
            isset($_POST['no']) &&
            isset($_POST['telp']) &&
            isset($_POST['gender'])
        ) {
            include_once("../connection.php");
    
            $no = htmlspecialchars($_POST['no']);
            $nama = htmlspecialchars($_POST['nama']);
            $gender = htmlspecialchars($_POST['gender']);
            $telp = htmlspecialchars($_POST['telp']);
            $alamat = htmlspecialchars($_POST['alamat']);
            $email = htmlspecialchars($_POST['email']);
            $date = date("Y/m/d");
    
            $result = mysqli_query($mysqli, 
            "INSERT 
                INTO anggota(no_anggota, nama, jk, telp, alamat, email, entry_date)
                VALUES ('$no', '$nama', '$gender', '$telp', '$alamat', '$email', '$date')
            ");
    
            echo "user gagal insert <br />";
            echo mysqli_error($mysqli);
            if (!mysqli_error($mysqli)) {
                $_SESSION['manage_user'] = "User berhasil di tambahkan.";
                header('Location: http://localhost/web-perpus/manage_users.php');
            }
        }
    } else {
      $_SESSION['masuk'] = false;
      header("Location: http://localhost/web-perpus/login.php");
    }
?>