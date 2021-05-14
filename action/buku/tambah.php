<?php 
      if(session_status() == PHP_SESSION_NONE) {session_start();}

      if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
          if (
              isset($_POST['kode_buku']) &&
              isset($_POST['isbn']) &&
              isset($_POST['judul']) &&
              isset($_POST['jumlah']) &&
              isset($_POST['penerbit']) &&
              isset($_POST['tahun']) &&
              isset($_POST['entry']) &&
              isset($_POST['penulis']) &&
              isset($_FILES['image'])
          ) {
              include_once("./save_img.php");
              if ($uploadOk !== 0)  {
                  include_once("../connection.php");
                  $kode_buku = htmlspecialchars($_POST['kode_buku']);
                  $isbn = htmlspecialchars($_POST['isbn']);
                  $judul = htmlspecialchars($_POST['judul']);
                  $jumlah = htmlspecialchars($_POST['jumlah']);
                  $penerbit = htmlspecialchars($_POST['penerbit']);
                  $tahun = htmlspecialchars($_POST['tahun']);
                  $entry = htmlspecialchars($_POST['entry']);
                  $penulis = htmlspecialchars($_POST['penulis']);
                  
                  $result = mysqli_query($mysqli, 
                  "INSERT 
                      INTO buku(kode, isbn, judul, penulis_kode, penerbit, tahun_terbit, jumlah, tidak_dipinjam, entry_date, images)
                      VALUES ('$kode_buku', '$isbn', '$judul', '$penulis', '$penerbit', '$tahun', '$jumlah', $jumlah, '$entry', '$name_file')
                  ");
      
                  if(mysqli_error($mysqli)) {
                    echo "user gagal insert <br />";
                    echo mysqli_error($mysqli);
                    unlink("../../uploads/buku/" . $name_file);
                  } else {
                    $_SESSION["manage_buku"] = 'Buku berhasil di tambah';
                    header('Location: http://localhost/web-perpus/manage_buku.php');
                  }
                  
              }
          }        
      } else {
        $_SESSION['masuk'] = false;
        header("Location: http://localhost/web-perpus/login.php");
      }
?>