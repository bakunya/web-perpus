<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (isset($_POST['id'])) {
            include_once("../connection.php");
    
            $id = $_POST['id'];
    
            $result = mysqli_query($mysqli, 
            "DELETE FROM
                anggota
            WHERE
                no_anggota = $id
            ");
            
            
    
            echo mysqli_error($mysqli);
            if (!mysqli_error($mysqli)) {
                echo "user successfully delete";
                echo $result;
                $_SESSION['manage_user'] = "User berhasil di hapus.";
                header('Location: http://localhost/web-perpus/manage_users.php');
            }
        }
    } else {
      $_SESSION['masuk'] = false;
      header("Location: http://localhost/web-perpus/login.php");
    }
?>