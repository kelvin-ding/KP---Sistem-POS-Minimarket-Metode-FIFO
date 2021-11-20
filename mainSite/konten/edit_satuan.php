<?php
      $id=$_GET['id'];
      $detail=query("SELECT * FROM product_uoms WHERE id='$id'");
?>

<!-- Form View Create -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit UoM</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_satuan&id=<?= $id;?>" class="btn btn-sm btn-outline-secondary">
            <span data-feather='x'></span>
            Cancel Edit
          </a>
        </div>
      </div>
<?php
if(isset($_SESSION['message'])){
  $message=$_SESSION['message'];
  if($message=='sukses'){
    echo '<div class="alert alert-success" role="alert">
             Satuan Berhasil Diubah! 
          </div>';
    unset($_SESSION['message']);
  }else{
    echo '<div class="alert alert-danger" role="alert">
             UoM has been registered! 
          </div>';
    unset($_SESSION['message']);
  }
}
?>
 <div class="row">
<div class="col-md-8 order-md-1">
      <form class="needs-validation" novalidate action='update_satuan' method='POST'>
      <?php 
                  foreach ($detail as $ddetail) :
                  ?>
        <div class="row">
          <div class="col-md-6 mb-3">
          <input type="hidden" name='id' value="<?php echo $ddetail['id']; ?>">
            <label for="UoMname">UoM Name</label>
            <input type="text" class="form-control" id="UoMname" placeholder="" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else{ echo $ddetail['name'];};?>" name='name' required>
            <div class="invalid-feedback">
              Valid name is required.
            </div>
          </div>
        </div>

        <input type="submit" name='submit' class="btn btn-primary" value='Submit'>
        <?php
                    endforeach;
        ?>
      </form>
    </div>
</div>
