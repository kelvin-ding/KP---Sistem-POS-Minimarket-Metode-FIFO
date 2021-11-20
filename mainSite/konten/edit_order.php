<?php 
$id=$_GET['id'];
$detail=query("SELECT a.status, a.total_amount, a.order_date, a.invoice_no, b.id AS sid, b.code AS scode, b.name AS supplier, a.total_amount, a.status  
                        FROM purchase_invoices AS a, suppliers AS b 
                        WHERE a.supplier_id = b.id AND a.id='$id'");
?>
<!-- Edit View -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Invoice</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="order&id=<?php echo $id;?>" class="btn btn-sm btn-outline-secondary">
            <span data-feather='x'></span>
            Cancel Edit
          </a>
        </div>
</div>
        
            <div class="col-lg-12">
            <?php foreach ($detail AS $ddetail):?>
        <form action="update_order&id=$id" method="POST">
            <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" name="invoice_no" value="<?php if(isset($_POST['invoice_no'])){ echo $_POST['invoice_no'];}else{ echo $ddetail['invoice_no'];}?>" class="form-control" style="width:200px;" required></th>
                    <th style="width:90px;padding-bottom:5px;">Supplier</th>
                    <td style="width:350px;">
                    <select name="supplier_id" class="selectpicker show-tick form-control" data-live-search="true" title="Pilih Suplier" data-width="100%" required>
                            <option selected value="<?php echo $ddetail['sid'];?>"><?php echo '['.$ddetail['scode'].']'.$ddetail['supplier'];?></option>
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
                    <td>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <input type="hidden" name='id' value='<?php echo $id;?>'>
                            <input type='submit' name='submit' value='Update'class="btn btn-sm btn-outline-secondary">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input type='date' name="date" class="form-control" value="<?= $ddetail['order_date'];?>" placeholder="Tanggal..." required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                </tr>
            </table><hr/>
            </form>
                        <?php endforeach;?>

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
                $line=query("SELECT a.id, a.sales_amount, b.code AS codep, b.name AS product, c.name AS uom, a.qty, a.unit_price, a.total_amount AS subtotal FROM purchase_invoice_lines AS a, products AS b, product_uoms AS c 
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
                         <td style="text-align:center;"> <a href='delete_purchase_line&id=<?php echo $dline['id'];?>' class="btn btn-warning btn-xs"><i class="fas fa-trash fa-sm text-white-50"></i></a></td>
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
            <!-- <a href="" class="btn btn-info btn-lg"><span class="fa fa-save"></span> Simpan</a> -->
            </div>
        </div>
        <!-- /.row -->
        <hr>
    </div>