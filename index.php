<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  include_once("./action/connection.php");

  $result = mysqli_query($mysqli, "SELECT * FROM galeri ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/style.css?v=2" />
    <title>Library</title>
  </head>
  <body>
    <nav>
      <section class="logo">
        <a href="#">School Library</a>
      </section>
      <section class="nav">
        <a href="/web-perpus/pinjam.php">Start Reading</a>
      </section>
      <section class="nav-right">
        <a href="/web-perpus/gallery.php">gallery</a>
        <a href="/web-perpus/index.php#profile">profile</a>
        <?php 
          if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
            echo '<a href="/web-perpus/pinjam.php">admin</a>';
            echo '<a href="/web-perpus/logout.php">Logout</a>';
          } else {
            echo '<a href="/web-perpus/login.php">signin</a>';
          }
        ?>
      </section>
    </nav>

    <section class="section">
      <article class="intro" id="profile">
        <section class="content">
          <h1>Library of Pajangan High School</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi
            suscipit tempora eum qui impedit molestias, sit consequuntur quae
            mollitia fuga placeat dolorem magnam explicabo? Recusandae
            aspernatur perferendis adipisci expedita eaque!
          </p>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi
            suscipit tempora eum qui impedit molestias, sit consequuntur quae
            mollitia fuga placeat dolorem magnam explicabo? Recusandae
            aspernatur perferendis adipisci expedita eaque!
            Commodi
          </p>
          <a href="/web-perpus/pinjam.php">Start Reading</a>
        </section>
        <img src="/web-perpus/img/intro.jpeg" />
      </article>

      <article class="visi-misi">
        <section class="visi">
          <h1>vision</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi
            suscipit tempora eum qui impedit molestias, sit consequuntur quae
            mollitia fuga placeat dolorem magnam explicabo? Recusandae
            aspernatur perferendis adipisci expedita eaque!
          </p>
        </section>

        <section class="misi">
          <h1>mision</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi
            suscipit tempora eum qui impedit molestias, sit consequuntur quae
            mollitia fuga placeat dolorem magnam explicabo? Recusandae
            aspernatur perferendis adipisci expedita eaque!
          </p>
        </section>
      </article>

      <article class="gallery" id="gallery">
      <h1>gallery</h1>
       <div class="content-gallery">
         <?php
          $i = 1;
          while ($image = mysqli_fetch_array($result)) {   
            echo '<div class="img">';
              echo '<img src="/web-perpus/uploads/galeri/'.$image['image'].'" id="p'.$i.'" />';
            echo '</div>';
            if ($i === 5) {
              break;
            }
            $i ++;
          }

         ?>
        </div>  
       </div>
      </article>
    </section>
    <script src="/web-perpus/script/script.js?v=3"></script>
  </body>
</html>
