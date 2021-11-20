<?php
$id=$_POST['id'];
$name=$_POST['name'];
$cek=mysqli_query($db,"SELECT name FROM categories WHERE name='$name' AND id!='$id'");
	$nrow=mysqli_num_rows($cek);
	if($nrow>0){

	echo "
		<script>
			alert('Nama Kategori Sudah Terpakai!')
			document.location.href = 'edit_kategori&id=$id';
		</script>
		";

	}else{
 	mysqli_query($db,"UPDATE categories SET name='$name' WHERE id='$id'");
 	echo "
	<script>
		document.location.href = 'data_kategori';
	</script>
	";
}
?>