<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  include_once("./action/auth/check_is_login.php");

  $check = check_login();

  if ($check) {
    include_once("./action/connection.php");
    
    $result = mysqli_query($mysqli, "SELECT * FROM penulis ORDER BY nama DESC");
  }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/web-perpus/style/style.css?v=1" />
    <link rel="stylesheet" href="/web-perpus/style/admin.css?v=1" />
    <link rel="stylesheet" href="/web-perpus/style/manage_buku.css?v=100">
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

    <h1 class="title">Manage Authors</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>author code</th>
                    <th>name</th>
                    <th>address</th>
                    <th>contact</th>
                    <th>action</th>
                </tr>
            </thead>
            
            <tbody> 
              <?php 

                while ($penulis = mysqli_fetch_array($result)) {
                  $kode = $penulis['kode'];
                  $nama = $penulis['nama'];
                  $alamat = $penulis['alamat'];
                  $telp = $penulis['telp'];

                  echo '<tr>';
                      echo '<td>'.$kode.'</td>';
                      echo '<td>'.$nama.'</td>';
                      echo '<td>'.$alamat.'</td>';
                      echo '<td>'.$telp.'</td>';
                      echo '<td>';
                          echo '<button class="update" data-id="1" onclick="openSezamUpdate(`update`, `'.$kode.', '.$nama.', '.$alamat.', '.$telp.'`)">update</button>';
                          echo '<button class="delete" data-id="1" onclick="openSezamDelete(`'.$kode.'`)">delete</button>';
                      echo '</td>';
                  echo '</tr>';
                }
              
              ?>
            </tbody>
        </table>
    </div>


    
    <section class="button-nav">M</section>
    <section class="button-add" onclick="openSezamUpdate('add', null)">+</section>
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
      <?php 

        if (isset($_SESSION['manage_penulis'])){
          echo "alert('".$_SESSION['manage_penulis']."')";
          unset($_SESSION['manage_penulis']);
        } 
        
      ?>
    </script>
    <script src="/web-perpus/script/helper.js?v=1"></script>
    <script src="/web-perpus/script/manage_penulis.js?v=5"></script>
  </body>
</html>
