<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cashier</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <a href="order" class="btn btn-sm btn-outline-secondary">
            <span data-feather='list'></span>
            List Transaction
          </a>
        </div>
</div>

<?php

//Invoice Number Format 
$date=date('Y-m-d');
$month=date('m');
$format=date('y-m-');
$loop_no = mysqli_query($db,"SELECT invoice_no FROM sales_invoices ORDER BY invoice_no DESC LIMIT 1");
$crow=mysqli_num_rows($loop_no);
    if($crow > 0) {
        if ($row = mysqli_fetch_assoc($loop_no)) {
                $m=$row['invoice_no'];
                $m=substr($m,3,2);
                if($m==$month){
                    $value2 = $row['invoice_no'];
                    $value2 = substr($value2, 7, 10);//separating numeric part
                    $value2 = $value2 + 1;//Incrementing numeric part
                    $value2 = $format. sprintf('%04s', $value2);//concatenating incremented value
                    $value = $value2;
                }else{
                    $value2 = $row['invoice_no'];
                    $value2 = substr($value2, 7, 10);//separating numeric part
                    $value2 = 0001;//Incrementing numeric part
                    $value2 = $format. sprintf('%04s', $value2);//concatenating incremented value
                    $value = $value2;
                }
        }
    } 
    //20-11-0001
    else {
        $value2 = $format.'0001';
        $value = $value2;
    }


            // //Create Alert
            //   if (isset($_POST["submit"])) {
            //     if (tambahsales($_POST) > 0) {
            //       $added_invoice=query("SELECT id FROM sales_invoices ORDER BY id DESC LIMIT 1");
            //       foreach ($added_invoice as $get_added_invoice) :
            //         $id=$get_added_invoice['id'];
            //       endforeach;
            //       header('location:sales&id='.$id);
            //       $_SESSION['message']='sukses';
            //     }else{
            //       $_SESSION['message']='failed';
            //             echo '<div class="alert alert-danger" role="alert">
            //             Failed to Create Invoice 
            //             </div>';
            //             unset($_SESSION['message']);
            //     }
            //   }
              ?>   
        
            <div class="col-lg-12">
            <form action="" method="POST">
            <table>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">Customer</th>
                    <th style="width:10px;padding-bottom:5px;"><input type="text" name="customer" placeholder='Nama Tamu' value="<?php if(isset($_POST['customer'])){ echo $_POST['customer'];}?>" class="form-control" style="width:200px;"></th>
                    <th style="width:130px;padding-bottom:5px;">Payment Method</th>
                    <th style="width:100px;padding-bottom:5px;">
                    <select name="payment" id="payment" class='form-control'>
                        <option value="Cash">By Cash</option>
                        <option value="Cash">Pending</option>
                    </select></th>
                </tr>
                <tr>
                    <th style="width:100px;padding-bottom:5px;">No Faktur</th>
                    <th style="width:300px;padding-bottom:5px;"><input type="text" disabled name="invoice_no" value="<?php if(isset($_POST['invoice_no'])){ echo $_POST['invoice_no'];}else{ echo $value;}?>" class="form-control" style="width:200px;" required></th>
                    <th style="width:100px;padding-bottom:5px;">Tanggal</th>
                    <th>
                        <div class='input-group date' id='datepicker' style="width:200px;">
                            <input disabled type='date' name="date" class="form-control" value="<?= $date;?>" placeholder="Tanggal..." required/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </th>
                </tr>
                <tr>

                </tr>
            </table><hr/>
            <table>
                <tr>
                    <th style="width:400px;">Product</th>
                    <th>Qty</th>
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
                    <th> <input type="submit" value='OK' name='submit' class="btn btn-primary btn-lg btn-block" /></th>
                </tr>

                    
                    </div>
            </table>
             </form>
            <table class="table table-bordered table-condensed" style="font-size:16px;margin-top:10px;">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:center;">UoM</th>
                        <th style="text-align:center;">Unit Price</th>
                        <th style="text-align:center;">Sub Total</th>
                        <th style="width:100px;text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
//cart
if (isset($_POST['product_id'],$_POST['qty'])) {
 
    $id = $_POST['product_id'];
    $qty=$_POST['qty'];
    
    $product = mysqli_query($db, "SELECT a.name, a.sell_amount, b.name AS uom, c.id as price_id FROM products AS a, product_uoms AS b, product_prices as c WHERE a.id = '$id'");
    $dt_product = $product->fetch_assoc();
   
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
   
    $index = -1;
    $cart = unserialize(serialize($_SESSION['cart']));
   
    // jika produk sudah ada dalam cart maka pembelian akan diupdate
    for ($i=0; $i<count($cart); $i++) {
     if ($cart[$i]['product_id'] == $id) {
      $index = $i;
      $_SESSION['cart'][$i]['qty'] = $qty;
      break;
     }
    }
   
    // jika produk belum ada dalam cart
    if ($index == -1) {
     $_SESSION['cart'][] = [
      'product_id' => $id,
      'name' => $dt_product['name'],
      'sell_amount' => $dt_product['sell_amount'],
      'qty' => $qty
     ];
    }
   }
   
if (!empty($_SESSION['cart'])) { 

    if(isset($_SESSION['cart'])) {
        $cart = unserialize(serialize($_SESSION['cart']));
        $index = 0;
        $no = 1;
        $total = 0;
        $total_bayar = 0;
    
        for ($i=0; $i<count($cart); $i++) {
         $total = $_SESSION['cart'][$i]['sell_amount'] * $_SESSION['cart'][$i]['qty'];
         $total_bayar += $total;
         

 ?>
                    <tr>
                         <td><?= $cart[$i]['name']; ?></td>
                         <td style="text-align:center;"><?= $cart[$i]['qty']; ?></td>
                         <td style="text-align:right;"></td>
                         <td style="text-align:right;">Rp <?= number_format($cart[$i]['sell_amount'],2); ?></td>
                         <td style="text-align:right;">Rp <?= number_format($total,2); ?></td>
                         <td style="text-align:center;"><a href='sales&index=<?= $index; ?>' class="btn btn-warning btn-xs"><i class="fas fa-trash fa-sm text-white-50"></i></a></td>
                    </tr>
        <?php
        $index++;
        }

?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:center;">Total</td>
                        <td style="text-align:right;">Rp. <?= number_format($total_bayar,2);?></td>
                    </tr>
                </tfoot>
            </table>
  <?php
    // hapus produk dalam cart
    if(isset($_GET['index'])) {
        $cart = unserialize(serialize($_SESSION['cart']));
        unset($cart[$_GET['index']]);
        $cart = array_values($cart);
        $_SESSION['cart'] = $cart;
    }
    }
}
?>
            <!-- <a href="" class="btn btn-info btn-lg"><span class="fa fa-save"></span> Simpan</a> -->
            </div>
        </div>
        <!-- /.row -->
        <hr>
    </div>
