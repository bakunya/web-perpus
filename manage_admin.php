<?php   
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  include_once("./action/auth/check_is_login.php");

  $check = check_login();

  if ($check) {
    include_once("./action/connection.php");

    $result = mysqli_query($mysqli, "SELECT * FROM admin ORDER BY username DESC");
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

    <h1 class="title">Manage Admin</h1>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>username</th>
                    <th>action</th>
                </tr>
            </thead>
            
            <tbody> 
              <?php 
                $i = 1;
                while ($admin = mysqli_fetch_array($result)) {
                  $username = $admin['username'];

                  echo '<tr>';
                      echo '<td>'.$i.'</td>';
                      echo '<td>'.$username.'</td>';
                      echo '<td>';
                          echo '<button class="update" data-id="1" onclick="openSezamUpdate(`update`, `'.$username.'`)">update</button>';
                          echo '<button class="delete" data-id="1" onclick="openSezamDelete(`'.$username.'`)">delete</button>';
                      echo '</td>';
                  echo '</tr>';

                  $i ++;
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

        if (isset($_SESSION['manage_admin'])){
          echo "alert('".$_SESSION['manage_admin']."')";
          unset($_SESSION['manage_admin']);
        } 
        
      ?>
    </script>
    <script src="/web-perpus/script/helper.js?v=1"></script>
    <script src="/web-perpus/script/manage_admin.js?v=1"></script>
  </body>
</html>
