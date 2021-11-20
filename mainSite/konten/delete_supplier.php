<?php
$id = $_GET["id"];

$query1=mysqli_query($db,"SELECT supplier_id FROM purchase_invoices WHERE supplier_id='$id'");
$num1=mysqli_num_rows($query1);


	if($num1>0){
		echo "
		<script>
			alert('Supplier Sudah Terpakai Pada Nota Pembelian!')
			document.location.href = 'data_supplier';
		</script>
		";
	}else{
		mysqli_query($db, "DELETE FROM suppliers WHERE id = $id");
	echo "
	<script>
		document.location.href = 'data_supplier';
	</script>
	";
	}


?>