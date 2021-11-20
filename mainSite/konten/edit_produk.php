<?php
      $id=$_GET['id'];
      $detail=query("SELECT 
      a.id, a.code, a.name, b.name AS category, b.id AS category_id, c.id AS uom_id, a.qty, c.name AS uom, a.sell_amount, a.brand, a.min_qty, a.max_qty, a.status
      FROM products AS a INNER JOIN categories AS b INNER JOIN product_uoms AS c 
      ON a.category_id=b.id AND a.uom_id=c.id WHERE a.id='$id'");
?>
 <!-- Form View Edit -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="data_produk&id=<?= $id;?>" class="btn btn-sm btn-outline-secondary">
            <span data-feather='x'></span>
            Cancel Edit
          </a>
        </div>
      </div>
      <?php
              if (isset($_POST["submit"])) {
                if (ubah($_POST) > 0) {
                  header('location:data_produk&id='.$id);
                  $_SESSION['message']='update';
                }else{
                  $_SESSION['message']='failed';
                  unset($_SESSION['message']);
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
        <?php 
           foreach ($detail as $ddetail) :
        ?>
        <input type="hidden" name='id' value="<?php echo $ddetail['id']; ?>">
          <div class="col-md-6 mb-3">
            <label for="defaultCode">Default Code</label>
            <input type="text" class="form-control" id="defaultCode" placeholder="" value="<?php if(isset($_POST['code'])){ echo $_POST['code'];}else{ echo $ddetail['code'];};?>" name='code' required='required'>
            <div class="invalid-feedback">
              Valid Default Code is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="productName">Product name</label>
            <input type="text" class="form-control" id="productName" placeholder="" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else{ echo $ddetail['name'];};?>" name='name' required>
            <div class="invalid-feedback">
              Valid Product name is required.
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="category">Category</label>
            <select name='category' class="d-block w-100 selectpicker" data-live-search="true" id="category" required>
                <option value="<?=$ddetail['category_id'];?>" selected><?= $ddetail['category'];?></option>
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
                <option value="<?=$ddetail['uom_id'];?>" selected><?= $ddetail['uom'];?></option>
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
          <input type="text" name='brand' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['brand'])){ echo $_POST['brand'];}else{ echo $ddetail['brand'];};?>'>
          <div class="invalid-feedback">
            Please enter a valid brand.
          </div>
        </div>

        <div class="mb-3">
          <label for="minQty">Minimal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='min_qty' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['min_qty'])){ echo $_POST['min_qty'];}else{ echo $ddetail['min_qty'];};?>'>
          <div class="invalid-feedback">
            Please enter a valid minimal qty.
          </div>
        </div>
        
        
        <div class="mb-3">
          <label for="minQty">Maximal Qty <span class="text-muted">(Optional)</span></label>
          <input type="number" name='max_qty' class="form-control" id="brand" placeholder="" value='<?php if(isset($_POST['max_qty'])){ echo $_POST['max_qty'];}else{ echo $ddetail['max_qty'];};?>'>
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
            <input type="text" name='sell_amount' class="form-control" id="sell_amount" placeholder="<?php echo number_format('0',2);?>" value='<?php if(isset($_POST['sell_amount'])){ echo $_POST['sell_amount'];}else{ echo $ddetail['sell_amount'];};?>' required>
            <div class="invalid-feedback" style="width: 100%;">
              Sell Price is required.
            </div>
          </div>
        </div>
        <?php 
           endforeach;
        ?>                 
        <hr class="mb-4">
        <input name='submit' value='Edit Product' class="btn btn-primary btn-lg btn-block" type="submit">
      </form>
    </div>
</div>