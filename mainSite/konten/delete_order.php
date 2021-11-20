<?php
$id = $_GET["id"];

$query=mysqli_query($db,"SELECT status FROM purchase_invoices WHERE id='$id'");
$data=mysqli_fetch_array($query);
$status=$data['status'];

if($status=='Draft'){
    $del=mysqli_query($db,"DELETE FROM purchase_invoices WHERE id='$id'");
    $delline=mysqli_query($db,"DELETE FROM purchase_invoice_lines WHERE order_id='$id'");
    echo "
		<script>
			document.location.href = 'order';
		</script>
		";
}else{
    echo "
		<script>
			alert('Validated Invoice tidak bisa dihapus!')
			document.location.href = 'order';
		</script>
		";
}

?>