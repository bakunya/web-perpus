<?php   
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  include_once("./action/connection.php");

  $semua_buku = mysqli_query($mysqli, "SELECT tidak_dipinjam, kode, isbn, judul, penerbit, tahun_terbit, jumlah, images FROM buku ORDER BY judul DESC");
  $semua_anggota = mysqli_query($mysqli, "SELECT no_anggota FROM anggota");

  $anggota_array = array();

  while ($anggota = mysqli_fetch_array($semua_anggota)) {
    array_push($anggota_array, $anggota['no_anggota']);
  }
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/web-perpus/style/style.css" />
    <link rel="stylesheet" href="/web-perpus/style/admin.css?v=4" />
    <link rel="stylesheet" href="/web-perpus/style/manage_buku.css?v=4">
    <title>Library</title>
  </head>
  <body>
    <nav>
      <section class="logo">
        <a href="/web-perpus/index.php">School Library</a>
      </section>
      <section class="nav-right">
        <a href="/web-perpus/gallery.php">gallery</a>
        <a href="/web-perpus/index.php#profile">profile</a>
        <?php 
          if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
            echo '<a href="/web-perpus/logout.php">Logout</a>';
          } else {
            echo '<a href="/web-perpus/login.php">signin</a>';
          }
        ?>
      </section>
    </nav>

    <article class="card">

      <?php 

        while ($buku = mysqli_fetch_array($semua_buku)) {
          $kode = $buku['kode'];
          $isbn = $buku['isbn'];
          $judul = $buku['judul'];
          $penerbit = $buku['penerbit'];
          $tahun = $buku['tahun_terbit'];
          $jumlah = $buku['jumlah'];
          $image = $buku['images'];
          $tidak_dipinjam= $buku['tidak_dipinjam'];
          
         echo '<section class="card">';
           echo '<div class="card-img">';
             echo '<img src="/web-perpus/uploads/buku/'.$image.'" alt="adachi" />';
           echo '</div>';
           echo '<section class="card-content">';
             echo '<h1>'.$judul.'</h1>';
             echo '<p>stock: '.$tidak_dipinjam.'</p>';
             echo '<div class="button-container">';
               echo '<button class="detail" onclick="openSezam(`'.$kode.', '.$isbn.', '.$judul.', '.$penerbit.', '.$tahun.', '.$jumlah.', '.$image.'`, `detail`)">Detail</button>';
               if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
                if ($tidak_dipinjam >= 1) {
                  echo '<button class="button-borrow" id="borrow" onclick="openSezam(`'.$kode.', '.$image.', '.$judul.'`, `borrow`)">Borrow</button>';
                 }
               }
             echo '</div>';
           echo '</section>';
         echo '</section>';
        }

      ?>

    </article>


    
    <section class="button-nav">M</section>
    <nav class="fixed-nav">
        <a href="/web-perpus/manage_buku.php">manage buku</a>
        <a href="/web-perpus/manage_penulis.php">manage penulis</a>
        <a href="/web-perpus/manage_users.php">manage users</a>
        <a href="/web-perpus/manage_admin.php">manage admin</a>
        <a href="/web-perpus/manage_gallery.php">manage gallery</a>
        <a href="/web-perpus/manage_pinjaman.php">manage pinjaman</a>
    </nav>

    <div class="modal-container-detail hidden">
      <div class="modal-detail">
        
      </div>
    </div>
    
    <script>
      const anggotaArray = <?php echo json_encode($anggota_array) ?>;  
    </script>
    <script>
      <?php 

        if (isset($_SESSION['tambah_pinjam'])){
          echo "alert('".$_SESSION['tambah_pinjam']."')";
          unset($_SESSION['tambah_pinjam']);
        } 
        
      ?>
    </script>
    <script src="/web-perpus/script/helper.js?v=3"></script>
    <script src="/web-perpus/script/admin.js?v=9"></script>
  </body>
</html>

