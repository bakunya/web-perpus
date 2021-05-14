<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
  if (isset($_SESSION['masuk']) === true) {
      if (
          isset($_POST['kode']) &&
          isset($_POST['alamat']) &&
          isset($_POST['nama']) &&
          isset($_POST['telp'])
      ) {
          include_once("../connection.php");
  
          $kode = htmlspecialchars($_POST['kode']);
          $nama = htmlspecialchars($_POST['nama']);
          $alamat = htmlspecialchars($_POST['alamat']);
          $telp = htmlspecialchars($_POST['telp']);
  
          $result = mysqli_query($mysqli, 
          "INSERT 
              INTO penulis(kode, nama, alamat, telp)
              VALUES ('$kode', '$nama', '$alamat', '$telp')
          ");

          echo mysqli_error($mysqli);
          if (!mysqli_error($mysqli)) {
            echo "user successfully insert";
            $_SESSION['manage_penulis'] = "Penulis berhasil di tambah.";
            header('Location: http://localhost/web-perpus/manage_penulis.php');
          }
      }
  } else {
    $_SESSION['masuk'] = false;
    header("Location: http://localhost/web-perpus/login.php");
  }

?>