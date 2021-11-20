<?php
	$nama = htmlspecialchars($_POST["nama"]);
 	
 	$cek=mysqli_query($db,"SELECT name FROM categories WHERE name='$nama'");
	$nrow=mysqli_num_rows($cek);
	if($nrow>0){

		header('location:data_kategori');
		$_SESSION['message']='failed';

	}else{
	 	$query = mysqli_query($db,"INSERT INTO categories SET name='$nama', status='active'");
		header('location:data_kategori');
	 	$_SESSION['message']='sukses';
	}

 ?>