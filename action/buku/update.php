<?php 
    if(session_status() == PHP_SESSION_NONE) {session_start();}

        if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
            if (
                isset($_POST['kode_buku']) &&
                isset($_POST['oldKode']) &&
                isset($_POST['isbn']) &&
                isset($_POST['judul']) &&
                isset($_POST['jumlah']) &&
                isset($_POST['penerbit']) &&
                isset($_POST['tahun']) &&
                isset($_POST['entry']) &&
                isset($_POST['penulis']) &&
                isset($_POST['tidak_dipinjam'])
            ) {
                if (isset($_FILES['image']) && strlen($_FILES['image']['name']) !== 0) {
                    include_once("./save_img.php");
                    if ($uploadOk !== 0)  {
                        include_once("../connection.php");
                        $kode_buku = htmlspecialchars($_POST['kode_buku']);
                        $oldKode = htmlspecialchars($_POST['oldKode']);
                        $isbn = htmlspecialchars($_POST['isbn']);
                        $judul = htmlspecialchars($_POST['judul']);
                        $jumlah = htmlspecialchars($_POST['jumlah']);
                        $penerbit = htmlspecialchars($_POST['penerbit']);
                        $tahun = htmlspecialchars($_POST['tahun']);
                        $entry = htmlspecialchars($_POST['entry']);
                        $penulis = htmlspecialchars($_POST['penulis']);
                        $oldImage = htmlspecialchars($_POST['oldImage']);
                        $tidak_dipinjam = htmlspecialchars($_POST['tidak_dipinjam']);
                        
                        $result = mysqli_query($mysqli, 
                        "UPDATE buku 
                            SET 
                                kode = '$kode_buku',
                                isbn = '$isbn',
                                judul = '$judul',
                                penulis_kode = '$penulis',
                                penerbit = '$penerbit',
                                tahun_terbit = '$tahun',
                                jumlah = '$jumlah',
                                entry_date = '$entry',
                                images = '$name_file',
                                tidak_dipinjam = '$tidak_dipinjam'
                            WHERE 
                                kode = '$oldKode'
                        ");
        
                        echo "user successfully insert";
                        echo mysqli_error($mysqli);
                        if(mysqli_error($mysqli)) {
                            unlink("../../uploads/buku/" . $name_file);
                        } else {
                            $_SESSION['manage_buku'] = "Buku berhasil di update.";
                            header('Location: http://localhost/web-perpus/manage_buku.php');
                            unlink("../../uploads/buku/" . $oldImage);
                        }
                    }
                } else {
                    include_once("../connection.php");
                    $kode_buku = htmlspecialchars($_POST['kode_buku']);
                    $isbn = htmlspecialchars($_POST['isbn']);
                    $judul = htmlspecialchars($_POST['judul']);
                    $jumlah = htmlspecialchars($_POST['jumlah']);
                    $penerbit = htmlspecialchars($_POST['penerbit']);
                    $tahun = htmlspecialchars($_POST['tahun']);
                    $entry = htmlspecialchars($_POST['entry']);
                    $penulis = htmlspecialchars($_POST['penulis']);
                    $oldKode = htmlspecialchars($_POST['oldKode']);
                    $tidak_dipinjam = htmlspecialchars($_POST['tidak_dipinjam']);


                    $result = mysqli_query($mysqli, 
                    "UPDATE buku 
                        SET 
                            kode = '$kode_buku',
                            isbn = '$isbn',
                            judul = '$judul',
                            penulis_kode = '$penulis',
                            penerbit = '$penerbit',
                            tahun_terbit = '$tahun',
                            jumlah = '$jumlah',
                            entry_date = '$entry',
                            tidak_dipinjam = '$tidak_dipinjam'
                        WHERE 
                            kode = '$oldKode'
                    ");
        
                    echo "user successfully insert";
                    echo mysqli_error($mysqli);
                    if(!mysqli_error($mysqli)) {
                        $_SESSION['manage_buku'] = "Buku berhasil di update.";
                        header('Location: http://localhost/web-perpus/manage_buku.php');
                    }
                }
            }
        } else {
            $_SESSION['masuk'] = false;
            header("Location: http://localhost/web-perpus/login.php");
        }

?>



