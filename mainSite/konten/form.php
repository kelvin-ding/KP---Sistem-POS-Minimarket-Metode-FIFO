<div class="col-md-4">
        <div class="card"  style="width: 25rem;">
          <div class="card-body">
              
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
                  $_SESSION['message']='failed';
                        echo '<div class="alert alert-danger" role="alert">
                        Kode Produk Sudah Terdaftar! 
                        </div>';
                        unset($_SESSION['message']);
                }
              }
              ?>    

                  <form action="" method="POST">
                  <label>Produk*</label>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input required='required' type="text" class="form-control" name='code' value="<?php if(isset($_POST['code'])){ echo $_POST['code'];};?>" placeholder="Kode Produk">
                        
                    </div>
                    <div class="col-sm-6">
                    <input required='required' type="text" class="form-control" name='name' placeholder="Nama Produk" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];};?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Kategori*</label>
                    <select required='required' name="category" id="category" class="form-control">
                    <option value="" disabled selected></option>
                      <?php 
                        $c=mysqli_query($db,"SELECT * FROM categories WHERE status='active'");
                        while($dc=mysqli_fetch_array($c)){
                      ?>
                      <option value="<?= $dc['id'];?>"><?= $dc['name'];?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Satuan*</label>
                    <select required='required' name="uom" id="uom" class="form-control">
                    <option value="" disabled selected></option>
                      <?php 
                        $uom=mysqli_query($db,"SELECT * FROM product_uoms WHERE status='active'");
                        while($duom=mysqli_fetch_array($uom)){
                      ?>
                      <option value="<?= $duom['id'];?>"><?= $duom['name'];?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Merek</label>
                      <input type="text" class="form-control" name='brand' placeholder="Merek Produk" value="<?php if(isset($_POST['brand'])){ echo $_POST['brand'];};?>">
                   
                  </div>
                  <div class="form-group">
                    <label>Minimal Quantity</label>
                    <input type="number" class="form-control" name='min_qty' placeholder="Minimal Qty" value="<?php if(isset($_POST['min_qty'])){ echo $_POST['min_qty'];};?>">
                  </div>

                  <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" class="form-control" name='sell_amount' placeholder="Harga Jual" value="<?php if(isset($_POST['sell_amount'])){ echo $_POST['sell_amount'];};?>">
                  </div>
                  
                  <input type="submit" name='submit' class="btn btn-primary" value='Submit'>
                </form>
            </div>
        </div>
    </div>