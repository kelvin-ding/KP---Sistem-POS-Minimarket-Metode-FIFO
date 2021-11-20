<?php
$date=date('Y-m-d');

$pi=query("SELECT a.id, a.order_date, a.invoice_no, b.name AS supplier, a.total_amount, a.status  FROM purchase_invoices AS a, suppliers AS b WHERE a.supplier_id = b.id ORDER BY a.order_date DESC");
if(!isset($_GET['id'])){ 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pembelian</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="order&id=" class="btn btn-sm btn-outline-secondary">
            <span data-feather="plus"></span>
            Create Invoice
          </a>
        </div>
</div>

<!-- List View -->
<div class="table-responsive">
                  <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Order Date</th>
                        <th>Invoice No</th>
                        <th>Supplier</th>
                        <!-- <th>Purchase Amount</th> -->
                        <th>Status</th>
                        <th>Option</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no=1;
                      foreach ($pi as $dr) : 
                      ?>
                      <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $dr['order_date'];?></td>
                        <td><?php echo $dr['invoice_no'];?></td>
                        <td><?php echo $dr['supplier'];?></td>
                        <!-- <td>Rp <?php echo number_format($dr['total_amount'],2);?></td> -->
                        <td><?php echo $dr['status'];?></td>
                        <td>  
                            <a href='order&id=<?php echo $dr['id'];?>' class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a>
                            <a href="delete_order&id=<?php echo $dr['id'];?>" onclick="return confirm('Apakah Anda Yakin?');" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i></a>
                        
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
    if($_GET['id']==''){
?>
<!-- Form View -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Invoice</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="order" class="btn btn-sm btn-outline-secondary">
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
                if (tambahorder($_POST) > 0) {
                  $added_invoice=query("SELECT id FROM purchase_invoices ORDER BY id DESC LIMIT 1");
                  foreach ($added_invoice as $get_added_invoice) :
                    $id=$get_added_invoice['id'];
                  endforeach;
                  header('location:order&id='.$id);
                  $_SESSION['message']='sukses';
                }else{
                  $_SESSION['message']='failed';
                        echo '<div class="alert alert-danger" role="alert">
                        Failed to Create Invoice 
                        </div>';
                        unset($_SESSION['message']);
                }
              }
              ?>   
        
            <div class="col-lg-12">
            <form action="" method="POST">
            <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" name="invoice_no" value="<?php if(isset($_POST['invoice_no'])){ echo $_POST['invoice_no'];}?>" class="form-control" style="width:200px;" required></th>
                    <th style="width:90px;padding-bottom:5px;">Supplier</th>
                    <td style="width:350px;">
                    <select name="supplier_id" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Suplier" data-width="100%" required>
                        <?php 
                            $supplier=query("SELECT * FROM suppliers WHERE status='active'");
                            foreach($supplier AS $dsup) :
                        ?>
                        <option value="<?php echo $dsup['id'];?>"><?php echo '['.$dsup['code'].']'.$dsup['name'];?></option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input type='date' name="date" class="form-control" value="<?= $date;?>" placeholder="Tanggal..." required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table><hr/>
            <table>
                <tr>
                    <th style="width:400px;">Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Sales Price</th>
                    <th></th>
                </tr>
                <tr>
                    <th><select name="product_id" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Produk" required>
                        <?php 
                            $product=query("SELECT * FROM products WHERE status='active'");
                            foreach($product AS $dp) :
                        ?>
                        <option value="<?php echo $dp['id'];?>"><?php echo '['.$dp['code'].']'.$dp['name'];?></option>
                        <?php
                            endforeach;
                        ?>
                    </select></th>
                    <th> <input type="number" name='qty' class="form-control" placeholder="" value="<?php if(isset($_POST['qty'])){ echo $_POST['qty'];};?>"  required></th>                     
                    <th> <input type="number" name='unit_price' class="form-control" placeholder="" value="<?php if(isset($_POST['unit_price'])){ echo $_POST['unit_price'];};?>" required></th>
                    <th> <input type="number" name='sales_amount' class="form-control" placeholder="" value="<?php if(isset($_POST['sales_amount'])){ echo $_POST['sales_amount'];};?>" required></th>
                    <th> <input type="submit" value='OK' name='submit' class="btn btn-primary btn-lg btn-block" /></th>
                </tr>

                    
                    </div>
            </table>
             </form>
            <table class="table table-bordered table-condensed" style="font-size:16px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:center;">Uom</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Sales Price</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                         <td></td>
                         <td style="text-align:center;"></td>
                         <td style="text-align:right;"></td>
                         <td style="text-align:right;"></td>
                         <td style="text-align:center;"></td>
                         <td style="text-align:right;"></td>
                         <td style="text-align:center;"><a href='#' class="btn btn-warning btn-xs"><i class="fas fa-trash fa-sm text-white-50"></i></a></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:center;">Total</td>
                        <td style="text-align:right;">Rp. </td>
                    </tr>
                </tfoot>
            </table>
            <!-- <a href="" class="btn btn-info btn-lg"><span class="fa fa-save"></span> Simpan</a> -->
            </div>
        </div>
        <!-- /.row -->
        <hr>
    </div>

<!-- Detail View-->
<?php
    }else{
        $id=$_GET['id'];
        $detail=query("SELECT a.status, a.total_amount, a.order_date, a.invoice_no, b.code AS scode, b.name AS supplier, a.total_amount, a.status  
                        FROM purchase_invoices AS a, suppliers AS b 
                        WHERE a.supplier_id = b.id AND a.id='$id'");
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Invoice</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="order" class="btn btn-sm btn-outline-secondary">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
              </svg>  
              Back
            </a>
            <?php 
             foreach ($detail as $ddetail) : $status=$ddetail['status']; endforeach;
            if($status=='Draft'){?>
            <a href="edit_order&id=<?php echo $id;?>" class="btn btn-sm btn-outline-secondary"><span data-feather="edit"></span> Edit</a>
            <a href="validate_order&id=<?php echo $id;?>" onclick="return confirm('Stok Produk Akan di Update Selelah Validate');"  class="btn btn-sm btn-outline-secondary"><span data-feather="check"></span> Validate</a>
            <?php }else{ ?>
              <button disabled class="btn btn-sm btn-outline-secondary"><span data-feather="edit"></span> Edit</button>
              <button disabled class="btn btn-sm btn-outline-secondary"><span data-feather="check"></span> Validated</button>
            <?php }?>
          </div>
        </div>
      </div>
      <?php 
    if(isset($_SESSION['message'])){
      if($_SESSION['message']=='sukses'){
          unset($_SESSION['message']);
          echo '<div class="alert alert-success" role="alert">
            Invoice has been created !
        </div>';
      }else if($_SESSION['message']=='update'){
        unset($_SESSION['message']);
        echo '<div class="alert alert-success" role="alert">
            Invoice Validated !
        </div>';
      }
    }
 ?>
        <!-- Detail View -->
            <div class="col-lg-12">
            <?php 
                foreach ($detail as $ddetail) : 
             ?>
            <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><?php echo $ddetail['invoice_no'];?></th>
                    <th style="width:90px;padding-bottom:5px;">Supplier</th>
                    <td style="width:350px;">
                    <?php echo '['.$ddetail['scode'].']'.$ddetail['supplier'];?>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <?= $ddetail['order_date'];?>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <hr/>
            <?php
              if (isset($_POST["submit"])) {
                if (tambahorderlines($_POST) > 0) {
                  header('location:order&id='.$id);
                    
                }else{
                  $_SESSION['message']='failed';
                        echo '<div class="alert alert-danger" role="alert">
                        Failed to Create Invoice 
                        </div>';
                        unset($_SESSION['message']);
                }
              }
              ?> 
            <form action="" method="POST">
            <input type="hidden" name="id" value=<?php echo $id;?>>
           <?php  if($ddetail['status']=='Draft'){?>
            <table>
                <tr>
                    <th style="width:400px;">Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Sales Price</th>
                    <th></th>
                </tr>
                <tr>
                    <th><select name="product_id" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Produk" required>
                        <?php 
                            $product=query("SELECT * FROM products WHERE status='active'");
                            foreach($product AS $dp) :
                        ?>
                        <option value="<?php echo $dp['id'];?>"><?php echo '['.$dp['code'].']'.$dp['name'];?></option>
                        <?php
                            endforeach;
                        ?>
                    </select></th>
                    <th><input type="number" name='qty' class="form-control" placeholder="" value="<?php if(isset($_POST['qty'])){ echo $_POST['qty'];};?>"  required></th>                     
                    <th> <input type="number" name='unit_price' class="form-control" placeholder="" value="<?php if(isset($_POST['unit_price'])){ echo $_POST['unit_price'];};?>" required></th>
                    <th> <input type="number" name='sales_amount' class="form-control" placeholder="" value="<?php if(isset($_POST['sales_amount'])){ echo $_POST['sales_amount'];};?>" required></th>
                    <th> <input type="submit" value='OK' name='submit' class="btn btn-primary btn-lg btn-block" /></th>
                </tr>

                    
                </div>
            </table>
                          <?php }?>
                <?php endforeach; ?>
             </form>

             <table class="table table-bordered table-condensed" style="font-size:16px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:center;">Uom</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Sales Price</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $line=query("SELECT a.id, b.code AS codep, a.sales_amount, b.name AS product, c.name AS uom, a.qty, a.unit_price, a.total_amount AS subtotal FROM purchase_invoice_lines AS a, products AS b, product_uoms AS c 
                WHERE a.product_id=b.id AND b.uom_id=c.id AND a.order_id='$id'");
                foreach($line AS $dline):
                ?>
                    <tr>
                         <td><?php echo '['.$dline['codep'].'] '.$dline['product'];?></td>
                         <td style="text-align:center;"><?php echo $dline['uom'];?></td>
                         <td style="text-align:right;"><?php echo $dline['qty'];?></td>
                         <td style="text-align:right;">Rp <?php echo number_format($dline['unit_price'],2);?></td>
                         <td style="text-align:right;">Rp <?php echo number_format($dline['sales_amount'],2);?></td>
                         <td style="text-align:right;">Rp <?php echo number_format($dline['subtotal'],2);?></td>
                         <?php 
                            foreach ($detail as $ddetail) : $status=$ddetail['status']; endforeach;
                            if($status=='Draft'){
                          ?>
                         <td style="text-align:center;"> <a href='delete_purchase_line&id=<?php echo $dline['id'];?>' class="btn btn-warning btn-xs"><i class="fas fa-trash fa-sm text-white-50"></i></a></td>
                        <?php
                            }else{
                              echo"<td></td>";
                            }
                        ?>
                    </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
                <tfoot>
                <?php 
                    foreach ($detail as $ddetail) : 
                ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Total</td>
                        <td style="text-align:right;">Rp <?php echo number_format($ddetail['total_amount'],2);?> </td>
                        <td style="text-align:right;"> </td>
                    </tr>
                    <?php
                        endforeach;
                    ?>
                </tfoot>
            </table>

<?php
    }
}
?>
