<?php
$id = $_GET["id"];

$query=mysqli_query($db,"SELECT uom_id FROM products WHERE uom_id='$id'");
	$num=mysqli_num_rows($query);
	if($num>0){
		echo "
		<script>
			alert('Satuan ini Sudah Terpakai Dalam Produk!')
			document.location.href = 'data_satuan';
		</script>
		";
	}else{
		mysqli_query($db, "DELETE FROM product_uoms WHERE id = $id");
	echo "
	<script>
		document.location.href = 'data_satuan';
	</script>
	";
	}


?>