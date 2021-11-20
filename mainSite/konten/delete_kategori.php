<?php
$id = $_GET["id"];

$query=mysqli_query($db,"SELECT category_id FROM products WHERE category_id='$id'");
	$num=mysqli_num_rows($query);
	if($num>0){
		echo "
		<script>
			alert('Kategori Sudah Terpakai Dalam Produk!')
			document.location.href = 'data_kategori';
		</script>
		";
	}else{
		mysqli_query($db, "DELETE FROM categories WHERE id = $id");
	echo "
	<script>
		document.location.href = 'data_kategori';
	</script>
	";
	}


?>