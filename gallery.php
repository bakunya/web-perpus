<?php
    if(session_status() == PHP_SESSION_NONE) {session_start();}

    include_once("./action/connection.php");

    $images = mysqli_query($mysqli, "SELECT image FROM galeri")

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/web-perpus/style/gallery.css">
    <title>Gallery</title>
</head>
<body>
    <nav>
        <section class="logo">
          <a href="/web-perpus/index.php">School Library</a>
        </section>
        <section class="nav">
          <a href="/web-perpus/login.php">Start Reading</a>
        </section>
        <section class="nav-right">
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

    <h1>gallery</h1>
    <div class="grid-container">
        <?php
        
            while ($image = mysqli_fetch_array($images)) {
                echo '<div class="img">';
                    echo '<img src="/web-perpus/uploads/galeri/'.$image['image'].'" alt="'.$image['image'].'" />';
                echo '</div>';
            }
        
        ?>
    </div>

    <div class="modal-container hidden">
        <div class="modal-gallery">
            <div class="img-modal">
                <img src="/web-perpus" alt="" srcset="" id="modal-img">
                <div class="prev"></div>
                <div class="next"></div>
            </div>
            <div class="button">
                <button id="prev"><</button>
                <button id="next">></button>
            </div>
        </div>
    </div>

    <script src="/web-perpus/script/gallery.js?v=3"></script>
</body>
</html>