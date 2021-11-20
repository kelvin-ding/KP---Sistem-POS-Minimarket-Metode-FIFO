<!-- Treeview -->
<?php 
$supplier=query("SELECT * 
               FROM suppliers ORDER BY id DESC");
if(!isset($_GET['id'])){ 
  ?>
    <!-- Page Heading -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Supplier Warung Zikry</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_supplier&id=tambah" class="btn btn-sm btn-outline-secondary">
            <span data-feather="plus"></span>
            Create Supplier
          </a>
        </div>
      </div>

            <!-- List View -->
                <div class="table-responsive">
                  <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Code</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no=1;
                      foreach ($supplier as $dr) : 
                      ?>
                      <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $dr['code'];?></td>
                        <td><?php echo $dr['name'];?></td>
                          <td>
                          <a href='status_supplier&id=<?php echo $dr['id'];?>' 
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
                            <a href='data_supplier&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a>
                            <a href='edit_supplier&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i></a>
                            <a href="delete_supplier&id=<?php echo $dr['id'];?>" onclick="return confirm('Apakah Anda Yakin?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                        
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
        <h1 class="h2">Form Supplier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_supplier" class="btn btn-sm btn-outline-secondary">
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
                if (tambahsupplier($_POST) > 0) {
                  $added_supplier=query("SELECT id FROM suppliers ORDER BY id DESC LIMIT 1");
                  foreach ($added_supplier as $get_added_supplier) :
                    $id=$get_added_supplier['id'];
                  endforeach;
                  header('location:data_supplier&id='.$id);
                  $_SESSION['message']='sukses';
                }else{
                  $_SESSION['message']='failed';
                        echo '<div class="alert alert-danger" role="alert">
                        Supplier Code Already Registered! 
                        </div>';
                        unset($_SESSION['message']);
                }
              }
              ?>    
<div class="row">
<div class="col-md-8 order-md-1">
      <form class="needs-validation" novalidate action='' method='POST'>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" id="defaultCode" placeholder="" value="<?php if(isset($_POST['code'])){ echo $_POST['code'];};?>" name='code' required='required'>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="SupplierName">Supplier name</label>
            <input type="text" class="form-control" id="SupplierName" placeholder="" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];};?>" name='name' required>
            <div class="invalid-feedback">
              Valid Supplier name is required.
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="phone">Phone Number <span class="text-muted">(Optional)</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">+62</span>
            </div>
            <input type="number" name='phone' class="form-control" id="phone" placeholder="853..." value='<?php if(isset($_POST['phone'])){ echo $_POST['phone'];};?>'>
            <div class="invalid-feedback" style="width: 100%;">
              Phone number is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="brand">Address <span class="text-muted">(Optional)</span></label>
          <textarea name="address" id="address" class="form-control" cols="30" rows="3"><?php if(isset($_POST['address'])){ echo $_POST['address'];};?></textarea> 
          <div class="invalid-feedback">
            Please enter a valid address.
          </div>
        </div>
        

        <hr class="mb-4">
        <input name='submit' value='Create Supplier' class="btn btn-primary btn-lg btn-block" type="submit">
      </form>
    </div>
</div>
              

<!-- Detail View-->
<?php
    }else{
      $id=$_GET['id'];
      $detail=query("SELECT * FROM suppliers
      WHERE id='$id'");
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Supplier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="data_supplier" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>  
              Back
            </a>
            <a href="edit_supplier&id=<?= $id;?>" class="btn btn-sm btn-outline-secondary">
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
            Supplier has been created !
        </div>';
      }else if($_SESSION['message']=='update'){
        unset($_SESSION['message']);
        echo '<div class="alert alert-success" role="alert">
            Supplier has been updated !
        </div>';
      }
    }
 ?>
 <div class="row">
<div class="col-md-8 order-md-1">
      <form class="needs-validation" novalidate action='' method='POST'>
      <?php 
                  foreach ($detail as $ddetail) :
      ?>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" id="defaultCode" placeholder="" value="<?= $ddetail['code'];?>" name='code' required='required' disabled>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="SupplierName">Supplier name</label>
            <input type="text" class="form-control" id="SupplierName" placeholder="" value="<?= $ddetail['name'];?>" name='name' required disabled>
            <div class="invalid-feedback">
              Valid Supplier name is required.
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="phone">Phone Number <span class="text-muted">(Optional)</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">+62</span>
            </div>
            <input type="text" name='phone' class="form-control" id="phone" placeholder="853..." value='<?= $ddetail['phone'];?>' disabled>
            <div class="invalid-feedback" style="width: 100%;">
              Phone number is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="brand">Address <span class="text-muted">(Optional)</span></label>
          <textarea name="address" id="address" class="form-control" cols="30" rows="3" disabled><?= $ddetail['address'];?></textarea> 
          <div class="invalid-feedback">
            Please enter a valid address.
          </div>
        </div>
        <hr class="mb-4">
      </form>
                  <?php endforeach;?>
    </div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Purchase History</h1>
      </div>
    <!-- Form View -->
              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Invoice No</th>
                              <th>Total Purchase</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no=1;
                              $inv=mysqli_query($db,"SELECT 
                                                    a.id, a.order_date, a.invoice_no, a.total_amount  
                                                    FROM purchase_invoices AS a, suppliers AS b
                                                    WHERE a.supplier_id = b.id AND
                                                    b.id='$id' AND 
                                                    a.status='validate'
                                                    ORDER BY a.id DESC
                                                      ");
                            while($dr=mysqli_fetch_array($inv)){  
                            ?>
                            <tr>
                              <td><?= $dr['order_date'];?></td>
                              <td><?= $dr['invoice_no'];?></td>
                              <td>Rp <?= number_format($dr['total_amount'],2);?></td>                            
                              <td><a href='detaik_invoicep&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a></td>
                            </tr>

                          <?php
                          }
                          ?>
                          </tbody>
                    </table>
              </div>
          </div>
 




<?php
    }
      
  }
   
?>