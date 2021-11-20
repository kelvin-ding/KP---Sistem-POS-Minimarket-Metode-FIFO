<!-- Data Kategori Produk -->
<!-- Page Heading -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Unit Of Measure</h1>
      </div>
<?php
if(isset($_SESSION['message'])){
  $message=$_SESSION['message'];
  if($message=='sukses'){
    echo '<div class="alert alert-success" role="alert">
             UoM has been created! 
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
<div class="col-md-10 order-md-1">
                <form method="post" action="tambah_satuan">
                  <table width="40%" border="0">
                    <tr align="justify-content-between">
                      <td width="20%">UoM :</td>
                      <td width="60%"><input type="text" class="form-control form-control-user" required="required" placeholder="" value="<?php if(isset($_POST['nama'])){ echo $_POST['nama'];};?>" style="width: 100%;" name="nama"></td>
                      <td width="20%"><input type="submit" class="btn btn-primary btn-user btn-block" style="width: 100%;" value="Add" name="submit"></td>
                    </tr>
                  </table>
                </form>
                <hr class="mb-4">
</div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="20px">No</th>
                      <th>UoM</th>
                      <th>Status</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $satuan=query("SELECT * FROM product_uoms ORDER BY id DESC");
                    
                    foreach ($satuan as $result) :
                    ?>
                    <tr>
                      <td><?php echo $no++;?></td>
                      <td>
                        <?php echo $result['name'];?> </td>
                      <td> <a href='status_satuan&id=<?php echo $result['id'];?>' 
                          <?php 
                          if($result['status']=='active'){
                            echo 'class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"';
                          }else{
                            echo 'class="d-none d-sm-inline-block btn btn-sm btn-danger  shadow-sm"';
                          }
                          ?>
                          >
                              <?php echo $result['status'];?>
                          </a></td>
                      <td> <a href='edit_satuan&id=<?php echo $result['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i></a>
                            <a href="delete_satuan&id=<?php echo $result['id'];?>" onclick="return confirm('Apakah Anda Yakin?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                    </td>
                    </tr>

                    <?php
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>
