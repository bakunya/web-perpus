<?php
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
    if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {    
            if (
                isset($_POST['id']) && 
                isset($_POST['peminjam']) && 
                isset($_POST['tenggat']) && 
                isset($_POST['date']) && 
                isset($_POST['denda'])
              ) 
              {
                include_once("../connection.php");
        
                $book_id = $_POST['id'];
                $peminjam = $_POST['peminjam'];
                $denda = $_POST['denda'];
                $tenggat = $_POST['tenggat'];
                $date_start = $_POST['date'];
                $date_end  = date('Y-m-d', strtotime('+'.$tenggat.' day', strtotime($date_start)));
                $uniq_id = uniqid($more_entropy = true);
        
                $tidak_dipinjam = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT tidak_dipinjam FROM buku WHERE kode = '$book_id'"))['tidak_dipinjam'];

                if ($tidak_dipinjam >= 1) {
                    mysqli_query($mysqli, "UPDATE buku SET tidak_dipinjam = $tidak_dipinjam - 1 WHERE kode = '$book_id'");
        
                    mysqli_query($mysqli, 
                    "INSERT 
                        INTO pinjam(id, kode_peminjam, kode_buku, tenggat, denda, date_start, date_end, lunas, total_denda)
                        VALUES ('$uniq_id', '$peminjam', '$book_id', $tenggat, $denda, '$date_start', '$date_end', false, 0)
                    ");
            
                    echo mysqli_error($mysqli);
                    
                    if (!mysqli_error($mysqli)) {
                        $_SESSION['manage_pinjaman'] = "Buku berhasil di pinjam.";
                        header("Location: http://localhost/web-perpus/pinjam.php");
                    }

                } else {
                    echo "buku telah dipinjam semua.";
                }    
              } 
    } else {
      $_SESSION['masuk'] = false;
      header("Location: http://localhost/web-perpus/login.php");
    }
?>