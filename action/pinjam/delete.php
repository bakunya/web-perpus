<?php 

    include_once("../auth/check_is_login.php");
    
    $check = check_login();
    
    function delete($id) {
        include_once("../connection.php");
        mysqli_query(
            $mysqli, 
            "DELETE FROM    
                pinjam 
            WHERE 
                id = '$id'
            "
        );

        if (!mysqli_error($mysqli)) {
            $_SESSION['manage_pinjaman'] = "Pinjaman berhasil di hapus";
            header("Location: http://localhost/web-perpus/manage_pinjaman.php");
        }
        echo "<br /> gagal delete pinjaman";
        echo mysqli_error($mysqli);
    }

    if ($check) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            delete($id);
        } else if (isset($_GET['id'])) {
            $id = $_GET['id'];
            delete($id);          
        }
    }

?>