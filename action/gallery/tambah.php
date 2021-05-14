<?php 

if(session_status() == PHP_SESSION_NONE) {session_start();}

  if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
    if (isset($_FILES['image'])) {
        include_once("./save_img.php");
        
        if ($uploadOk !== 0) {
            include_once("../connection.php");
            mysqli_query($mysqli, 
                "INSERT 
                    INTO galeri(image)
                    values('$name_file')
                "
            );
            echo mysqli_error($mysqli);
            if (mysqli_error($mysqli)) {
              unlink("../../uploads/galeri/" . $name_file);
            } else {
              $_SESSION['manage_galeri'] = "Gallery berhasil di tambah.";
              header('Location: http://localhost/web-perpus/manage_gallery.php');
            }
        }
    }
  } else {
    $_SESSION['masuk'] = false;
    header("Location: http://localhost/web-perpus/login.php");
  }

?>