<?php
$id=$_GET['id'];
$time_validate=date('Y-m-d H:i:s');
    $query= mysqli_query($db,"UPDATE purchase_invoices SET status='Validated', updated_at='$time_validate' WHERE id='$id'");
     
     $selectfc=mysqli_query($db,"SELECT a.order_date, b.sales_amount, b.qty, b.unit_price, b.product_id FROM purchase_invoices AS a, purchase_invoice_lines AS b WHERE a.id=b.order_id AND b.order_id='$id'");
     foreach ($selectfc AS $data):
        $all=array(
        'order_date' => $order_date=$data['order_date'],
        'qty'        => $qty=$data['qty'],
        'unit_price' => $unit_price=$data['unit_price'],
        'sales_amount' => $sales_amount=$data['sales_amount'],
        'product_id' => $product_id=$data['product_id'],
        'sbeli' => $sbeli=$unit_price * $qty
        );
                        
        //Current_Qty
        $cq=mysqli_query($db,"SELECT qty FROM products WHERE id='$data[product_id]'");
        foreach ($cq as $cqp):
           $aq=array($current_qty=$cqp['qty']);
        endforeach;

        //Current Price
        $cp= mysqli_query($db,"SELECT average_unit_price FROM product_prices WHERE is_latest=1 AND product_id='$data[product_id]'");
        foreach($cp AS $p): 
           if(empty($p['average_unit_price'])){
            $p['average_unit_price']=0;
           }
            $current_unit_price= $p['average_unit_price'];        
        endforeach;

            //New Prices
            $modal=$current_qty * $current_unit_price;  
            $sbeli; 
            $total_qty=$current_qty+$qty;
            $average_unit_price=($modal + $sbeli)/$total_qty;
            
        $update_islatest=mysqli_query($db,"UPDATE product_prices SET is_latest=0 where product_id='$product_id'");

        //insert price
        $price_insert=mysqli_query($db,"INSERT INTO product_prices SET product_id='$product_id', start_date='$order_date', purchase_qty='$qty', purchase_unit_price='$unit_price', average_unit_price='$average_unit_price', order_id=$id, is_latest=1,current_qty='$current_qty', current_unit_price='$current_unit_price'");
        $add_qty=mysqli_query($db,"UPDATE products SET qty=qty+'$qty', sell_amount='$sales_amount' WHERE id='$product_id'");
     endforeach;

     header('location:order&id='.$id);




?>