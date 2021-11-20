<?php
include "koneksi.php";
require 'konten/function.php';
date_default_timezone_set('Asia/Jakarta');
$time_validate=date('Y-m-d H:i:s');

if(isset($_SESSION['id'])){
  $id_user=$_SESSION['id'];
  $firstname=$_SESSION['nama'];
}else{
  header('location:../');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Dashboard Warung Zikry</title>


    <!-- Bootstrap core CSS -->
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/css/datatable.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=BASEURL::BASE_URL;?>/mainSite/assets/css/bootstrap-select.min.css">

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
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/css/dashboard.css" rel="stylesheet">
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?=BASEURL::BASE_URL;?>/mainSite/assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Warung Zikry</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="logout">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="home">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sales">
              <span data-feather="briefcase"></span>
              Sales
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="order">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data_produk">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data_kategori">
              <span data-feather="tag"></span>
              Category
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data_satuan">
              <span data-feather="box"></span>
              Unit of Measure
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data_supplier">
              <span data-feather="users"></span>
              Suppliers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="data_kas">
              <span data-feather="dollar-sign"></span>
              Cash
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Current month
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Last quarter
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Social engagement
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li>
        </ul>
      </div>
    </nav>
<div class="container-fluid">
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <?php
      if(isset($_GET['page'])){
        $page='konten/'.$_GET['page'].'.php';
            if(file_exists($page)){
              include($page);
            }else{
                include('konten/404.php');
            }
        }else{
            include('konten/home.php');
        }
        ?>
    </main>
</div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/bootstrap-select.min.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/dashboard.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/form-validation.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/jquery.dataTables.min.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/jquery-3.5.1.js"></script>
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/multiple-datatable.js"></script>
              
        <!-- Page level plugins -->
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/datatables/jquery.dataTables.min.js"></script>
        <script src="datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/datatables-demo.js"></script>
        <!-- <script type="text/javascript">
         $(function() {
              $('#typeselector').change(function(){
                  $('.type').hide();
                  $('#' + $(this).val()).show();
              });
          });
        </script> -->
        <script type="text/javascript">
          $('select[name=type]').change(function () {
                  if ($(this).val() == 'Withdraw') {
                      $('#typeselect').show();
                      $('#need_for').prop('required',true);
                  } else {
                      $('#need_for').prop('required',false);
                      $('#typeselect').hide();
                  }
              });
        </script>
        
        <!-- Show Input Box For Selected
        <script src="<?=BASEURL::BASE_URL;?>/mainSite/assets/js/jquery.min.js"></script>
        <script type="text/javascript">
              $(function() {
            $("select").on("change", function() {
                if($(this).val() === "") {
                    $("[data-parent]").hide();
                } else {
                    $("input[data-parent='" + $(this).val() + "']").show().siblings("[data-parent]").hide();
                }
            });
        });
        </script> 
        
        Ex:
        <select>
            <option value="">Choose</option>
            <option value="A">A</option>
        </select>
        <input data-parent="A" type="text" placeholder="additional info for A">
        -->

        
    </body>
</html>
