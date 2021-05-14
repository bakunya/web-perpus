<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (isset($_POST['image'])) {
            include_once("../connection.php");
    
            $id = $_POST['id'];
            $image = $_POST['image'];
    
            mysqli_query($mysqli, 
                "DELETE FROM
                    galeri
                 WHERE 
                    id = $id
                "
            );
    
            echo mysqli_error($mysqli);
            if (!mysqli_error($mysqli)) {
                unlink("../../uploads/galeri/" . $image);
                $_SESSION['manage_galeri'] = "Galeri berhasil di delete.";
                header('Location: http://localhost/web-perpus/manage_gallery.php');
            }
        }
    } else {
      $_SESSION['masuk'] = false;
      header("Location: http://localhost/web-perpus/login.php");
    }

?>