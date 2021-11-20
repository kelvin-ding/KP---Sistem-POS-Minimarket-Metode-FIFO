<?php

$id = $_GET["id"];
	$query=mysqli_query($db,"SELECT status FROM suppliers WHERE id=$id");
	$data=mysqli_fetch_array($query);
	
	if($data['status']=='active'){
	mysqli_query($db, "UPDATE suppliers SET status='non-active' WHERE id = '$id'");	
	header('location:data_supplier');
	}else{
	mysqli_query($db, "UPDATE suppliers SET status='active' WHERE id = '$id'");
	header('location:data_supplier');
	}
?>