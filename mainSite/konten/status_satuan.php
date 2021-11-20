<?php

$id = $_GET["id"];
	$query=mysqli_query($db,"SELECT status FROM product_uoms WHERE id=$id");
	$data=mysqli_fetch_array($query);
	
	if($data['status']=='active'){
	mysqli_query($db, "UPDATE product_uoms SET status='non-active' WHERE id = '$id'");	
	header('location:data_satuan');
	}else{
	mysqli_query($db, "UPDATE product_uoms SET status='active' WHERE id = '$id'");
	header('location:data_satuan');
	}
?>