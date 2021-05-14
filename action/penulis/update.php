<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
  if (isset($_SESSION['masuk']) === true) {
      if (
          isset($_POST['kode']) &&
          isset($_POST['alamat']) &&
          isset($_POST['nama']) &&
          isset($_POST['oldKode']) &&
          isset($_POST['telp'])
      ) {
          include_once("../connection.php");

          $kode = htmlspecialchars($_POST['kode']);
          $oldKode = htmlspecialchars($_POST['oldKode']);
          $nama = htmlspecialchars($_POST['nama']);
          $alamat = htmlspecialchars($_POST['alamat']);
          $telp = htmlspecialchars($_POST['telp']);

          $result = mysqli_query($mysqli, 
          "UPDATE penulis
              SET 
                  kode = '$kode',
                  nama = '$nama',
                  alamat = '$alamat',
                  telp = '$telp'
            WHERE kode = '$oldKode'
          ");

          echo "user successfully insert";
          if (mysqli_error($mysqli)) {
              echo mysqli_error($mysqli);
          } else {
              $_SESSION['manage_penulis'] = "Penulis berhasil di update.";
              header('Location: http://localhost/web-perpus/manage_penulis.php');
          }
      }
  } else {
    $_SESSION['masuk'] = false;
    header("Location: http://localhost/web-perpus/login.php");
  }

?>