<?php 
  if(session_status() == PHP_SESSION_NONE) {session_start();}

  include_once("./action/auth/check_cookie.php");
  
  if (isset($_SESSION['masuk']) && $_SESSION['masuk'] === true) {
    header("Location: http://localhost/web-perpus/pinjam.php");
  } else {
    $cookie = CheckCookie();
    if ($cookie === true) {
      header("Location: http://localhost/web-perpus/pinjam.php");        
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/web-perpus/style/form.css" />
    <link rel="stylesheet" href="/web-perpus/style/style.css" />
    <title>Sign In</title>
  </head>
  <body>
    <nav>
      <section class="logo">
        <a href="/web-perpus/index.php">School Library</a>
      </section>
      <section class="nav-right">
        <a href="/web-perpus/index.php#profile">profile</a>
      </section>
    </nav>

    <section class="container login">
      <div class="form">
        <h1>Sign In</h1>
        <form method="post" action="/web-perpus/action/auth/login.php">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" />
          <label for="password">password</label>
          <input type="password" name="password" id="password" />
          <button class="btn" name="submit" type="submit">Login</button>
        </form>
      </div>
    </section>

    <script>
      <?php 

        if (isset($_SESSION['auth_error'])){
          echo "alert('".$_SESSION['auth_error']."')";
          unset($_SESSION['auth_error']);
        } 
        
      ?>
    </script>
  </body>
</html>
