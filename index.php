<?php
include "mainSite/koneksi.php";
if(isset($_SESSION['id'])){
    header('location:mainSite/');
  }else{
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Signin - Warung Zikry</title>

    <!-- Bootstrap core CSS -->
<link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <div class="card mx-auto">
    <div class="card-body">
        <form class="form-signin" action="<?=BASEURL::BASE_URL;?>/cek_login.php" method="POST">
        <img class="mb-4" src="<?=BASEURL::BASE_URL;?>/mainSite/assets/img/logo.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Warung Zikry</h1>
        <label class="sr-only">Username</label>
        <input type="text" name="username"  class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox mb-3">
            <label>
            </label>
        </div>
        <input class="btn btn-lg btn-primary btn-block" type="submit" name='login' value="Sign in">
        <p class="mt-5 mb-3 text-muted">&copy; Universitas Intertasional Batam 2020</p>
        </form>
    </div>
</div>
</body>
</html>
<?php
}
?>