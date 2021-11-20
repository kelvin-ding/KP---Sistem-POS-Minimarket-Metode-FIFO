<?php
	$nama = htmlspecialchars($_POST["nama"]);
 	
 	$cek=mysqli_query($db,"SELECT name FROM product_uoms WHERE name='$nama'");
	$nrow=mysqli_num_rows($cek);
	if($nrow>0){

		header('location:data_satuan');
		$_SESSION['message']='failed';

	}else{
	 	$query = mysqli_query($db,"INSERT INTO product_uoms SET name='$nama', status='active'");
		header('location:data_satuan');
	 	$_SESSION['message']='sukses';
	}

 ?>