<?php
$id = $_GET["id"];

$order=mysqli_query($db,"SELECT order_id, total_amount FROM purchase_invoice_lines WHERE id='$id'");
$data=mysqli_fetch_array($order);
$gid=$data['order_id'];
$total_amount=$data['total_amount'];

$update=mysqli_query($db,"UPDATE purchase_invoices SET total_amount=total_amount-'$total_amount' WHERE id='$gid'");
$delete=mysqli_query($db, "DELETE FROM purchase_invoice_lines WHERE id ='$id'");


header('location:order&id='.$gid);

?>