<?php
$id=$_POST['id'];
$name=$_POST['name'];
$cek=mysqli_query($db,"SELECT name FROM product_uoms WHERE name='$name' AND id!='$id'");
	$nrow=mysqli_num_rows($cek);
	if($nrow>0){

	echo "
		<script>
			alert('Nama Satuan Sudah Terpakai!')
			document.location.href = 'edit_satuan&id=$id';
		</script>
		";

	}else{
 	mysqli_query($db,"UPDATE product_uoms SET name='$name' WHERE id='$id'");
 	echo "
	<script>
		document.location.href = 'data_satuan';
	</script>
	";
}
?>