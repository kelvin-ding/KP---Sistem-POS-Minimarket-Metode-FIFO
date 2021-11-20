<?php

$id = $_GET["id"];
	$query=mysqli_query($db,"SELECT status FROM categories WHERE id=$id");
	$data=mysqli_fetch_array($query);
	
	if($data['status']=='active'){
	mysqli_query($db, "UPDATE categories SET status='non-active' WHERE id = '$id'");	
	header('location:data_kategori');
	}else{
	mysqli_query($db, "UPDATE categories SET status='active' WHERE id = '$id'");
	header('location:data_kategori');
	}
?>