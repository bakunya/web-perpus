<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}
  
  include_once("./action/auth/check_is_login.php");
  
  $check = check_login();
  
  if ($check) {
    include_once("./action/connection.php");
  
    $penulisKode = mysqli_query($mysqli, "SELECT kode, nama FROM penulis ORDER BY kode DESC");
    $semua_buku = mysqli_query($mysqli, "SELECT * FROM buku ORDER BY judul DESC");
  
    $penulisArray = array();
  
    while ($kode = mysqli_fetch_array($penulisKode)) {
      array_push($penulisArray, (object)[
        'kode' => $kode['kode'],
        'nama' => $kode['nama']
      ]);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/web-perpus/style/style.css" />
    <link rel="stylesheet" href="/web-perpus/style/admin.css" />
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
          if ($_SESSION['username']) {
            echo '<a href="/web-perpus/pinjam.php">admin</a>';
            echo '<a href="/web-perpus/logout.php">Logout</a>';
          }
        ?>
      </section>
    </nav>

    <h1 class="title">Manage Book</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>book code</th>
                    <th>ISBN</th>
                    <th>title</th>
                    <th>publisher</th>
                    <th>action</th>
                </tr>
            </thead>
            
            <tbody> 
              <?php 

                while ($buku = mysqli_fetch_array($semua_buku)) {     
                  $kode = $buku['kode'];
                  $isbn = $buku['isbn'];
                  $judul = $buku['judul'];
                  $jumlah = $buku['jumlah'];
                  $penerbit = $buku['penerbit'];
                  $tahun = $buku['tahun_terbit'];
                  $entry = $buku['entry_date'];
                  $penulis = $buku['penulis_kode'];
                  $images = $buku['images'];
                  $tidak_dipinjam = $buku['tidak_dipinjam'];

                  echo '<tr>';
                      echo '<td>'.$kode.'</td>';
                      echo '<td>'.$isbn.'</td>';
                      echo '<td>'.$judul.'</td>';
                      echo '<td>'.$penerbit.'</td>';
                      echo '<td>';
                          echo '<button class="update" data-id="1" onclick="openSezamUpdate(`update`, `'.$kode.', '.$isbn.', '.$judul.', '.$jumlah.', '.$penerbit.', '.$tahun.', '.$entry.', '.$penulis.', '.$images.', '.$tidak_dipinjam.'`)">update</button>';
                          echo '<button class="delete" data-id="1" onclick="openSezamDelete(`'.$kode.', '.$images.'`)">delete</button>';
                      echo '</td>';
                  echo '</tr>';

                }
              
              ?>
            </tbody>
        </table>
    </div>


    
    <section class="button-nav">M</section>
    <section class="button-add" onclick="openSezamUpdate('add')">+</section>
    <nav class="fixed-nav">
        <a href="/web-perpus/manage_buku.php">manage buku</a>
        <a href="/web-perpus/manage_penulis.php">manage penulis</a>
        <a href="/web-perpus/manage_users.php">manage users</a>
        <a href="/web-perpus/manage_admin.php">manage admin</a>
        <a href="/web-perpus/manage_gallery.php">manage gallery</a>
        <a href="/web-perpus/manage_pinjaman.php">manage pinjaman</a>
    </nav>

    <div class="modal-container hidden">
        <div class="modal-content">
        </div>
    </div>

    <script>
      const penulisKode = <?php echo json_encode($penulisArray) ?>
    </script>
        <script>
      <?php 

        if (isset($_SESSION['manage_buku'])){
          echo "alert('".$_SESSION['manage_buku']."')";
          unset($_SESSION['manage_buku']);
        } 
        
      ?>
    </script>
    <script src="/web-perpus/script/helper.js?v=1"></script>
    <script src="/web-perpus/script/manage_buku.js?v=7"></script>
  </body>
</html>