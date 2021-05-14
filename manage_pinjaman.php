<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  include_once("./action/auth/check_is_login.php");

  $check = check_login();

  if ($check) {
    include_once("./action/connection.php");
    $semua_pinjaman = mysqli_query($mysqli, "SELECT * FROM pinjam LEFT JOIN (SELECT no_anggota, nama FROM anggota) as agt ON pinjam.kode_peminjam = agt.no_anggota INNER JOIN (SELECT kode, judul FROM buku) as bk ON pinjam.kode_buku = bk.kode");
    $semua_kodepeminjam = mysqli_query($mysqli, "SELECT no_anggota FROM anggota");
    $semua_kodebuku = mysqli_query($mysqli, "SELECT kode FROM buku WHERE tidak_dipinjam != 0");

    $array_kodepeminjam = array();
    $array_kodebuku = array();
    while ($kode = mysqli_fetch_assoc($semua_kodebuku)) {
      array_push($array_kodebuku, $kode['kode']);
    }
    while ($kode = mysqli_fetch_assoc($semua_kodepeminjam)) {
      array_push($array_kodepeminjam, $kode['no_anggota']);
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
    <link rel="stylesheet" href="/web-perpus/style/manage_buku.css?v=5">
    <style>
      .detail{
        padding: 5px 23px;
        border: none;
        outline: none;
        font-size: 1rem;
        border-radius: 5px;
        transition: 450ms all;
        font-weight: 600;
        text-transform: capitalize;
        cursor: pointer;
        margin: 0 5px;
        background: #06de06;
        color: white;
      }


      .kembali{    
          padding: 5px 20px;
          border: none;
          outline: none;
          font-size: 1rem;
          border-radius: 5px;
          transition: 300ms all;
          font-weight: 600;
          text-transform: capitalize;
          cursor: pointer;
          margin: 0 5px;
          background-color: rgb(12, 168, 179);
          color: white;
        }

        button:hover,
        button:active,
        a.detail:hover,
        a.detail:active{
            background-color: #2d483a !important;
            color: white !important;
        }

        .action {
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
        }

        .action button,
        .action a {
          margin: 3px;
        }
    </style>
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

    <h1 class="title">Manage Pinjaman</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>no.</th>
                    <th>peminjam</th>
                    <th>kode peminjam</th>
                    <th>buku</th>
                    <th>kode buku</th>
                    <th>mulai pinjam</th>
                    <th>akhir pinjaman</th>
                    <th>lunas</th>
                    <th>action</th>
                </tr>
            </thead>
            
            <tbody> 
              <?php 
                $i = 1;
                while ($pinjaman = mysqli_fetch_array($semua_pinjaman)) {
                  $id = $pinjaman['id'];
                  $kode_peminjam = $pinjaman['kode_peminjam'];
                  $kode_buku = $pinjaman['kode_buku'];
                  $tenggat = $pinjaman['tenggat'];
                  $denda = $pinjaman['denda'];
                  $date_start = $pinjaman['date_start'];
                  $date_end = $pinjaman['date_end'];
                  $lunas = $pinjaman['lunas'];
                  $nama = $pinjaman['nama'];
                  $judul = $pinjaman['judul'];

                  echo '<tr>';
                      echo '<td>'.$i.'</td>';
                      echo '<td>'.$nama.'</td>';
                      echo '<td>'.$kode_peminjam.'</td>';
                      echo '<td>'.$judul.'</td>';
                      echo '<td>'.$kode_buku.'</td>';
                      echo '<td>'.$date_start.'</td>';
                      echo '<td>'.$date_end.'</td>';
                      if ($lunas == 1) {
                        echo '<td style="color: green;">lunas</td>';
                      } else {
                        echo '<td style="color: red;">belum</td>';
                      }
                      echo '<td class="action">';
                          echo '<button class="update" data-id="1" onclick="openSezamUpdate(`'.$id.', '.$kode_peminjam.', '.$kode_buku.', '.$tenggat.', '.$denda.', '.$date_start.', '.$date_end.', '.$lunas.'`)">update</button>';
                          if ($lunas === "0") {
                            echo '<button class="delete" data-id="1" onclick="alert(`Buku belum di kembalikan.`)">Hapus</button>';
                            echo '<a class="detail" href="/web-perpus/detail_pinjaman.php?id='.$id.'" style="background:#004e00;">Mengembalikan</a>';
                          } else {
                            echo '<button class="delete" data-id="1" onclick="openSezamDelete(`'.$id.'`)">Hapus</button>';
                            echo '<a class="detail" href="/web-perpus/detail_pinjaman.php?id='.$id.'">Mengembalikan</a>';
                          }
                      echo '</td>';
                  echo '</tr>';

                  $i ++;
                }
              
              ?>
            </tbody>
        </table>
    </div>


    <div class="modal-container hidden">
        <div class="modal-content">
        </div>
    </div>

    
    <section class="button-nav">M</section>
    <nav class="fixed-nav">
        <a href="/web-perpus/manage_buku.php">manage buku</a>
        <a href="/web-perpus/manage_penulis.php">manage penulis</a>
        <a href="/web-perpus/manage_users.php">manage users</a>
        <a href="/web-perpus/manage_admin.php">manage admin</a>
        <a href="/web-perpus/manage_gallery.php">manage gallery</a>
        <a href="/web-perpus/manage_pinjaman.php">manage pinjaman</a>
    </nav>

    <script>
      const kodepeminjam = <?php echo json_encode($array_kodepeminjam); ?>;
      const kodebuku = <?php echo json_encode($array_kodebuku); ?>;
    </script>
    <script>
      <?php 

        if (isset($_SESSION['manage_pinjaman'])){
          echo "alert('".$_SESSION['manage_pinjaman']."')";
          unset($_SESSION['manage_pinjaman']);
        } 
        
      ?>
    </script>
    <script src="/web-perpus/script/helper.js?v=1"></script>
    <script src="/web-perpus/script/manage_pinjaman.js?v=8"></script>
  </body>
</html>