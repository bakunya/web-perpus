<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
      if (
          isset($_POST['kode'])
      ) {
          include_once("../connection.php");
  
          $post = $_POST['kode'];
  
          $result = mysqli_query($mysqli, 
          "DELETE FROM
              penulis
            WHERE 
              kode = '$post'
          ");

          if (!mysqli_error($mysqli)) {
            $_SESSION["manage_penulis"] = "Penulis berhasil di hapus.";
            header('Location: http://localhost/web-perpus/manage_penulis.php');
          }

          echo mysqli_error($mysqli);
          echo "<br />user gagal update";
      }
  
  } else {
    $_SESSION['masuk'] = false;
    header("Location: http://localhost/web-perpus/login.php");
  }
?>