<!-- Treeview -->
<?php 
$produk=query("SELECT 
               a.id, a.code, a.name, b.name AS category, a.qty, c.name AS uom, a.sell_amount, a.status 
               FROM products AS a INNER JOIN categories AS b INNER JOIN product_uoms AS c 
               ON a.category_id=b.id AND a.uom_id=c.id ORDER BY a.id DESC");
if(!isset($_GET['id'])){ 
  ?>   
  <!-- Page Heading -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Products Warung Zikry</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_produk&id=tambah" class="btn btn-sm btn-outline-secondary">
            <span data-feather="plus"></span>
            Create Product
          </a>
        </div>
      </div>
            <!-- List View -->
                <div class="table-responsive">
                  <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Qty Ready</th>
                        <th>UoM</th>
                        <th>Sales Price</th>
                        <th>Status</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no=1;
                      foreach ($produk as $dr) : 
                      ?>
                      <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo '['.$dr['code'].'] '.$dr['name'];?></td>
                        <td><?php echo $dr['category'];?></td>
                        <td><?php echo $dr['qty'];?></td>
                        <td><?php echo $dr['uom'];?></td>
                        <td>Rp <?= number_format($dr['sell_amount'],2);?></td>
                        <td>
                          <a href='status_produk&id=<?php echo $dr['id'];?>' 
                          <?php 
                          if($dr['status']=='active'){
                            echo 'class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"';
                          }else{
                            echo 'class="d-none d-sm-inline-block btn btn-sm btn-danger  shadow-sm"';
                          }
                          ?>
                          >
                              <?php echo $dr['status'];?>
                          </a>
                        </td>
                        <td>  
                            <a href='data_produk&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a>
                            <a href='edit_produk&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i></a>
                            <a href="delete_produk&id=<?php echo $dr['id'];?>" onclick="return confirm('Apakah Anda Yakin?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                        
                        </td>
                      </tr>

                    <?php
                       endforeach;
                    ?>
                    </tbody>
                  </table>
                </div>



<?php 
  }else if(isset($_GET['id']))
  {
    if($_GET['id']=='tambah'){
?>
 <!-- Form View Create -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_produk" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>
            Back
          </a>
        </div>
      </div>
      <?php
              if (isset($_POST["submit"])) {
                if (tambah($_POST) > 0) {
                  $added_produk=query("SELECT id FROM products ORDER BY id DESC LIMIT 1");
                  foreach ($added_produk as $get_added_produk) :
                    $id=$get_added_produk['id'];
                  endforeach;
                  header('location:data_produk&id='.$id);
                  $_SESSION['message']='sukses';
                }else{
                        echo '<div class="alert alert-danger" role="alert">
                        Product Code Already Registered! 
                        </div>';
                }
              }
              ?>   
<div class="row">
<div class="col-md-8 order-md-1">
      <form class="needs-validation" novalidate action='' method='POST'>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" id="defaultCode" placeholder="" value="<?php if(isset($_POST['code'])){ echo $_POST['code'];}?>" name='code' required='required'>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="productName">Product name</label>
            <input type="text" class="form-control" id="productName" placeholder="" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];};?>" name='name' required>
            <div class="invalid-feedback">
              Valid Product name is required.
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="category">Category</label>
            <select name='category' class=" d-block w-100 selectpicker" data-live-search="true" id="category" required>
              <option value="">Choose...</option>
              <?php 
                        $c=mysqli_query($db,"SELECT * FROM categories WHERE status='active'");
                        while($dc=mysqli_fetch_array($c)){
              ?>
                      <option value="<?= $dc['id'];?>"><?= $dc['name'];?></option>
              <?php  } ?>
            </select>
            <div class="invalid-feedback">
              Please select a valid category.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="uom">Unit of Measure</label>
            <select name='uom' class="d-block w-100 selectpicker" data-live-search="true" id="uom" required>
              <option value="">Choose...</option>
              <?php 
                        $uom=mysqli_query($db,"SELECT * FROM product_uoms WHERE status='active'");
                        while($duom=mysqli_fetch_array($uom)){
                      ?>
                      <option value="<?= $duom['id'];?>"><?= $duom['name'];?></option>
                <?php
                        }
               ?>
            </select>
            <div class="invalid-feedback">
              Please provide a valid Unit of Measure.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="brand">Brand <span class="text-muted">(Optional)</span></label>
          <input type="text" name='brand' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['brand'])){ echo $_POST['brand'];};?>'>
          <div class="invalid-feedback">
            Please enter a valid brand.
          </div>
        </div>

        <div class="mb-3">
          <label for="minQty">Minimal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='min_qty' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['min_qty'])){ echo $_POST['min_qty'];};?>'>
          <div class="invalid-feedback">
            Please enter a valid minimal qty.
          </div>
        </div>

        <div class="mb-3">
          <label for="minQty">Maximal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='max_qty' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['max_qty'])){ echo $_POST['max_qty'];};?>'>
          <div class="invalid-feedback">
            Please enter a valid maximal qty.
          </div>
        </div>

        <div class="mb-3">
          <label for="sell_amount">Sell Amount</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" name='sell_amount' class="form-control" id="sell_amount" placeholder="<?php echo number_format('0',2);?>" value='<?php if(isset($_POST['sell_amount'])){ echo $_POST['sell_amount'];};?>' required>
            <div class="invalid-feedback" style="width: 100%;">
              Sell Price is required.
            </div>
          </div>
        </div>

        <hr class="mb-4">
        <input name='submit' value='Create Product' class="btn btn-primary btn-lg btn-block" type="submit">
      </form>
    </div>
</div>


<!-- Detail View-->
<?php
    }else{
      $id=$_GET['id'];
      $detail=query("SELECT 
      a.id, a.code, a.name, b.name AS category, a.qty, c.name AS uom, a.sell_amount, a.brand, a.min_qty, a.max_qty, a.status
      FROM products AS a INNER JOIN categories AS b INNER JOIN product_uoms AS c 
      ON a.category_id=b.id AND a.uom_id=c.id WHERE a.id='$id'");
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="data_produk" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>  
              Back
            </a>
            <a href="edit_produk&id=<?= $id;?>" class="btn btn-sm btn-outline-secondary">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
              Edit
            </a>
          </div>
        </div>
      </div>

  <?php 
    if(isset($_SESSION['message'])){
      if($_SESSION['message']=='sukses'){
          unset($_SESSION['message']);
          echo '<div class="alert alert-success" role="alert">
          Product has been created!
        </div>';
      }else if($_SESSION['message']=='update'){
        unset($_SESSION['message']);
        echo '<div class="alert alert-success" role="alert">
        Product has been updated!
        </div>';
      }
    }
 ?>
 <div class="row">
<div class="col-md-8 order-md-1">
  <?php foreach ($detail as $ddetail) :?>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" placeholder="" value="<?= $ddetail['code'];?>" name='code' disabled required>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="productName">Product name</label>
            <input type="text" class="form-control" id="productName" placeholder="" value="<?= $ddetail['name'];?>" name='name' disabled required>
            <div class="invalid-feedback">
              Valid Product name is required.
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" placeholder="" value="<?= $ddetail['category'];?>" name='category' disabled required>
            <div class="invalid-feedback">
              Please select a valid category.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="uom">Unit of Measure</label>
            <input type="text" class="form-control" id="uom" placeholder="" value="<?= $ddetail['uom'];?>" name='uom' disabled required>
            <div class="invalid-feedback">
              Please provide a valid Unit of Measure.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="brand">Brand <span class="text-muted">(Optional)</span></label>
          <input type="text" name='brand' class="form-control" id="brand" placeholder="" value='<?= $ddetail['brand'];?>' disabled>
          <div class="invalid-feedback">
            Please enter a valid brand.
          </div>
        </div>

        <div class="mb-3">
          <label for="minQty">Minimal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='min_qty' class="form-control" id="brand" placeholder="" value='<?= $ddetail['min_qty'];?>' disabled>
          <div class="invalid-feedback">
            Please enter a valid minimal qty.
          </div>
        </div>
        
        <div class="mb-3">
          <label for="minQty">Maximal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='max_qty' class="form-control" id="brand" placeholder="" value='<?= $ddetail['max_qty'];?>' disabled>
          <div class="invalid-feedback">
            Please enter a valid Maximal qty.
          </div>
        </div>

        <div class="mb-3">
          <label for="sell_amount">Sell Amount</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Rp</span>
            </div>
            <input type="text" name='sell_amount' class="form-control" id="sell_amount" placeholder="<?php echo number_format('0',2);?>" value='<?= number_format($ddetail['sell_amount'],2);?>' disabled>
            <div class="invalid-feedback" style="width: 100%;">
              Sell Price is required.
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="category">Stock Ready</label>
          <input type="text" class="form-control" id="category" placeholder="" value="<?= $ddetail['qty'];?>" name='qty' disabled required>
          <div class="invalid-feedback">
            Please select a valid category.
           </div>
        </div>

        <?php   endforeach; ?>               
        <hr class="mb-4">
    </div>
</div>

<!-- Product Price Heading-->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Product Price</h1>
      </div>

<?php
$produk=query("SELECT b.start_date, c.invoice_no, b.current_qty, b.current_unit_price, b.purchase_qty, b.purchase_unit_price, b.average_unit_price,b.is_latest 
                                                        FROM 
                                                        products AS a, product_prices AS b, purchase_invoices as C WHERE 
                                                        a.id=b.product_id AND 
                                                        b.order_id=c.id AND
                                                        b.product_id='$id' 
                                                        ORDER BY b.id DESC
                                                          ");
?>
      <!-- Price View -->
      <div class="card-body">
                      <div class="table-responsive">
                          <table class="table" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Update Date</th>
                                  <th>Invoice No</th>
                                  <th>Stock Before </th>
                                  <th>Price Before</th>
                                  <th>Stock Added</th>
                                  <th>Buying Price</th>
                                  <th>Average Unit Price</th>
                                  <th>Is Latest </th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $no=1;
                               foreach ($produk as $dr) :
                               ?>
                                <tr>
                                  <td><?= $dr['start_date'];?></td>
                                  <td><?= $dr['invoice_no'];?></td>
                                  <td><?= $dr['current_qty'];?></td>
                                  <td><?= $dr['current_unit_price'];?></td>
                                  <td><?= $dr['purchase_qty'];?></td>
                                  <td><?= $dr['purchase_unit_price'];?></td>
                                  <td>Rp <?= number_format($dr['average_unit_price'],2);?></td>
                                  <td><input disabled type='checkbox' <?php if($dr['is_latest']==1){ echo"checked";}else{};?>/></td>
                                </tr>

                              <?php
                              endforeach;
                              ?>
                              </tbody>
                        </table>
                  </div>
              </div>
              <!-- End of price View-->
  
  </div>
<?php
    }
      
  }
   
?>