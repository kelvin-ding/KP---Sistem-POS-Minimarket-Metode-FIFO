<?php

$id = $_GET["id"];
	$query=mysqli_query($db,"SELECT status FROM products WHERE id=$id");
	$data=mysqli_fetch_array($query);
	
	if($data['status']=='active'){
	mysqli_query($db, "UPDATE products SET status='non-active' WHERE id = '$id'");	
	header('location:data_produk');
	}else{
	mysqli_query($db, "UPDATE products SET status='active' WHERE id = '$id'");
	header('location:data_produk');
	}
?>