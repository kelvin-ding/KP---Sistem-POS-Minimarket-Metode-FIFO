<?php
$id = $_GET["id"];

$query1=mysqli_query($db,"SELECT product_id FROM purchase_invoice_lines WHERE product_id='$id'");
$num1=mysqli_num_rows($query1);

$query2=mysqli_query($db,"SELECT product_id FROM sales_invoice_lines WHERE product_id='$id'");
$num2=mysqli_num_rows($query2);

$query3=mysqli_query($db,"SELECT product_id FROM product_prices WHERE product_id='$id'");
$num3=mysqli_num_rows($query3);

	if($num1>0){
		echo "
		<script>
			alert('Produk Sudah Terpakai Nota Pembelian!')
			document.location.href = 'data_produk';
		</script>
		";
	}else if($num2>0){
				echo "
		<script>
			alert('Produk Sudah Terpakai Transaksi Penjualan!')
			document.location.href = 'data_produk';
		</script>
		";
	}else if($num3>0){
				echo "
		<script>
			alert('Produk Sudah Terpakai Dalam Nota Pembelian!')
			document.location.href = 'data_produk';
		</script>
		";
	}else{
		mysqli_query($db, "DELETE FROM products WHERE id = $id");
	echo "
	<script>
		document.location.href = 'data_produk';
	</script>
	";
	}


?>