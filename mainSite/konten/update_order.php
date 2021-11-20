<?php
$id=$_POST['id'];
$invoice_no = htmlspecialchars($_POST["invoice_no"]);
$date = htmlspecialchars($_POST["date"]);
$supplier_id = $_POST["supplier_id"];

$update=mysqli_query($db,"UPDATE purchase_invoices SET invoice_no='$invoice_no', order_date='$date', supplier_id='$supplier_id' WHERE id='$id'");

     header('location:order&id='.$id);
?>