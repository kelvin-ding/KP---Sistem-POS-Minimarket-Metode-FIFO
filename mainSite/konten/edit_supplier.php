<?php
$id=$_GET['id'];
$detail=query("SELECT * FROM suppliers
WHERE id='$id'");
?>
 <!-- Form View Create -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Supplier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_supplier&id=<?= $id;?>" class="btn btn-sm btn-outline-secondary">
            <span data-feather='x'></span>
            Cancel Edit
          </a>
        </div>
      </div>
      <?php
          if (isset($_POST["submit"])) {
            if (ubahsupplier($_POST) > 0) {
              header('location:data_supplier&id='.$id);
              $_SESSION['message']='update';
            }else{
              $_SESSION['message']='failed';
              unset($_SESSION['message']);
                echo '<div class="alert alert-danger" role="alert">
                          Supplier Code Already Registered! 
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
          <input type="hidden" name='id' value="<?php echo $ddetail['id']; ?>">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" id="defaultCode" placeholder="" value="<?php if(isset($_POST['code'])){ echo $_POST['code'];}else{ echo $ddetail['code'];};?>" name='code' required='required'>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="SupplierName">Supplier name</label>
            <input type="text" class="form-control" id="SupplierName" placeholder="" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else{ echo $ddetail['name'];};?>" name='name' required>
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
            <input type="number" name='phone' class="form-control" id="phone" placeholder="853..." value='<?php if(isset($_POST['phone'])){ echo $_POST['phone'];}else{ echo $ddetail['phone'];};?>'>
            <div class="invalid-feedback" style="width: 100%;">
              Phone number is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="brand">Address <span class="text-muted">(Optional)</span></label>
          <textarea name="address" id="address" class="form-control" cols="30" rows="3"><?php if(isset($_POST['address'])){ echo $_POST['address'];}else{ echo $ddetail['address'];};?></textarea> 
          <div class="invalid-feedback">
            Please enter a valid address.
          </div>
        </div>
        

        <hr class="mb-4">
        <input name='submit' value='Edit Supplier' class="btn btn-primary btn-lg btn-block" type="submit">
        <?php
                    endforeach;
        ?>
      </form>
    </div>
</div>