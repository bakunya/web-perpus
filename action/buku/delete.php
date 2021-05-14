<?php 

    if(session_status() == PHP_SESSION_NONE) {session_start();}
    
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
        if (
            isset($_POST['id']) &&
            isset($_POST['image'])
        ) {
            include_once("../connection.php");
    
            $id = $_POST['id'];
            $image = $_POST['image'];
    
            $result = mysqli_query($mysqli, 
            "DELETE FROM
                buku
            WHERE
                kode = '$id'
            ");        
    
            echo mysqli_error($mysqli);
            if(!mysqli_error($mysqli)) {
                unlink("../../uploads/buku/" . $image);
                $_SESSION['manage_buku'] = "Buku berhasil di hapus.";
                header('Location: http://localhost/web-perpus/manage_buku.php');
            };
            echo "user successfully delete";
        }
    } else {
        $_SESSION['masuk'] = false;
        header("Location: http://localhost/web-perpus/login.php");
    }
?>