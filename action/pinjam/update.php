<?php 

    include_once("../auth/check_is_login.php");
    include_once("../connection.php");

    $check = check_login($mysqli);

    if ($check) {
        if (
            isset($_POST['id']) &&
            isset($_POST['buku']) &&
            isset($_POST['peminjam']) &&
            isset($_POST['tenggat']) &&
            isset($_POST['denda']) &&
            isset($_POST['start']) &&
            isset($_POST['akhir'])
        ) 
        {
            include_once("../connection.php");
            $id = $_POST['id'];
            $buku = $_POST['buku'];
            $peminjam = $_POST['peminjam'];
            $tenggat = $_POST['tenggat'];
            $denda = $_POST['denda'];
            $start = $_POST['start'];
            $akhir = $_POST['akhir'];


            mysqli_query($mysqli, 
                "UPDATE    
                    pinjam 
                SET 
                    kode_buku = '$buku',
                    kode_peminjam = '$peminjam',
                    tenggat = '$tenggat',
                    denda = '$denda',
                    date_start = '$start',
                    date_end = '$akhir'
                WHERE id = '$id'
                ");

            if (!mysqli_error($mysqli)) {
                $_SESSION['manage_pinjaman'] = "Pinjaman berhasil di update";
                header("Location: http://localhost/web-perpus/manage_pinjaman.php");
            }
            echo mysqli_error($mysqli);
        }
    }

?>