<?php 

include_once("../auth/check_is_login.php");
include_once("../connection.php");

$check = check_login($mysqli);

if ($check) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        mysqli_query(
            $mysqli, 
            "UPDATE 
                buku, pinjam 
            SET 
                buku.tidak_dipinjam = buku.tidak_dipinjam + 1, pinjam.total_denda = 0, pinjam.lunas = true 
            WHERE 
                buku.kode = pinjam.kode_buku AND pinjam.id = '$id'"
        );

        echo mysqli_error($mysqli);
        if (!mysqli_error($mysqli)) {
            $_SESSION['manage_pinjaman'] = "Buku berhasil di kembalikan.";
            header("Location: http://localhost/web-perpus/manage_pinjaman.php");
        }
    }
}

?>