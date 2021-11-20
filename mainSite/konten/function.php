<?php
function query ($query){
	global $db;
	$result = mysqli_query($db, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}
//Function Produk
function tambah($data){
	global $db;

	$code = htmlspecialchars($data["code"]);
	$name = htmlspecialchars($data["name"]);
	$category = htmlspecialchars($data["category"]);
	$uom = htmlspecialchars($data["uom"]);
	$brand = htmlspecialchars($data["brand"]);
	$min_qty = htmlspecialchars($data["min_qty"]);
	$max_qty = htmlspecialchars($data["max_qty"]);
	$sell_amount = htmlspecialchars($data["sell_amount"]);
	$qty=0;

	$cek_code=mysqli_query($db,"SELECT code FROM products WHERE code='$code'");
	$nrow=mysqli_num_rows($cek_code);
	if($nrow>0){

	return false;

	}else{
	 	$query = "INSERT INTO products SET 
													code='$code', 
													name='$name', 
													category_id='$category', 
													brand='$brand', 
													uom_id='$uom', 
													min_qty='$min_qty', 
													max_qty='$max_qty', 
													sell_amount='$sell_amount',
													qty='$qty', 
													status='active'";
		$added_produk=mysqli_query($db,"SELECT id FROM products ORDER BY id DESC LIMIT 1");

	}
		
	
 	mysqli_query($db, $query);


 	return mysqli_affected_rows($db);
 }

	

function ubah($data){
	global $db;
	$id = $data["id"];
	$code = htmlspecialchars($data["code"]);
	$name = htmlspecialchars($data["name"]);
	$category = htmlspecialchars($data["category"]);
	$uom = htmlspecialchars($data["uom"]);
	$brand = htmlspecialchars($data["brand"]);
	$min_qty = htmlspecialchars($data["min_qty"]);
	$max_qty = htmlspecialchars($data["max_qty"]);
	$sell_amount = htmlspecialchars($data["sell_amount"]);

 	$cek_code=mysqli_query($db,"SELECT code FROM products WHERE code='$code' AND id!='$id'");
	$nrow=mysqli_num_rows($cek_code);
	if($nrow>0){

	return false;

	}else{
 	$query = "UPDATE products SET
 	 												code='$code', 
													name='$name', 
													category_id='$category', 
													brand='$brand', 
													uom_id='$uom', 
													min_qty='$min_qty', 
													max_qty='$max_qty', 
													sell_amount='$sell_amount'
													WHERE id='$id' 
 	 ";
 	 
 	}
 	mysqli_query($db, $query);
 	$n=1;
 	 return $n;
}
// End Function produk

//Function Supplier
function tambahsupplier($data){
	global $db;

	$code = htmlspecialchars($data["code"]);
	$name = htmlspecialchars($data["name"]);
	$address = htmlspecialchars($data["address"]);
	$phone = htmlspecialchars($data["phone"]);

	$cek_code=mysqli_query($db,"SELECT code FROM suppliers WHERE code='$code'");
	$nrow=mysqli_num_rows($cek_code);
	if($nrow>0){

	return false;

	}else{
	 	$query = "INSERT INTO suppliers SET 
					code='$code', 
					name='$name',
					address='$address',
					phone='$phone',
					status='active'";
	}
		
	
 	mysqli_query($db, $query);


 	return mysqli_affected_rows($db);
 }

 function ubahsupplier($data){
	global $db;
	$id = $data["id"];
	$code = htmlspecialchars($data["code"]);
	$name = htmlspecialchars($data["name"]);
	$address = htmlspecialchars($data["address"]);
	$phone = htmlspecialchars($data["phone"]);

 	$cek_code=mysqli_query($db,"SELECT code FROM suppliers WHERE code='$code' AND id!='$id'");
	$nrow=mysqli_num_rows($cek_code);
	if($nrow>0){

	return false;

	}else{
 	$query = "UPDATE suppliers SET
 	 		code='$code', 
			name='$name', 
			address='$address',
			phone='$phone'
			WHERE id='$id' 
 	 ";
 	 
 	}
 	mysqli_query($db, $query);
 	$n=1;
 	 return $n;
}


//Function Cash
function form_cash($data){
	global $db;

	$date = htmlspecialchars($data["date"]);
	$type = htmlspecialchars($data["type"]);
	$need_for = htmlspecialchars($data["need_for"]);
	$amount = htmlspecialchars($data["amount"]);
	$description = htmlspecialchars($data["description"]);
	$status='Draft';


	 	$query = "INSERT INTO form_cashes SET 
					date='$date', 
					type='$type',
					need_for='$need_for',
					amount='$amount',
					description='$description',
					status='$status'";
		
	
 	mysqli_query($db, $query);


 	return mysqli_affected_rows($db);
 }

 function ubah_form_cash($data){
	global $db;
	$id = htmlspecialchars($data["id"]);
	$date = htmlspecialchars($data["date"]);
	$type = htmlspecialchars($data["type"]);
	$need_for = htmlspecialchars($data["need_for"]);
	$amount = htmlspecialchars($data["amount"]);
	$description = htmlspecialchars($data["description"]);


 	$query = "UPDATE form_cashes SET 
	 date='$date', 
	 type='$type',
	 need_for='$need_for',
	 amount='$amount',
	 description='$description'
	 WHERE id='$id'
	 ";
 	 
 	mysqli_query($db, $query);
 	$n=1;
 	 return $n;
}


//Function Purchase
function tambahorder($data){
	global $db;

	$invoice_no = htmlspecialchars($data["invoice_no"]);
	$date = htmlspecialchars($data["date"]);
	$supplier_id = htmlspecialchars($data["supplier_id"]);
	$product_id = htmlspecialchars($data["product_id"]);
	$qty = htmlspecialchars($data["qty"]);
	$unit_price = htmlspecialchars($data["unit_price"]);
	$sales_amount = htmlspecialchars($data["sales_amount"]);
	$total_amount=$qty * $unit_price;

	$query = "INSERT INTO purchase_invoices SET
				order_date='$date',
				invoice_no='$invoice_no',
				supplier_id='$supplier_id',
				total_amount='$total_amount',
				status='Draft'
	";
	mysqli_query($db, $query);
	$select_id=mysqli_query($db,"SELECT id FROM purchase_invoices ORDER BY id DESC LIMIT 1");
	$data=mysqli_fetch_array($select_id);
	$id=$data['id'];
	$invoice_lines=mysqli_query($db,"INSERT INTO purchase_invoice_lines SET
					order_id='$id',
					product_id='$product_id',
					qty='$qty',
					unit_price='$unit_price',
					sales_amount='$sales_amount',
					total_amount='$total_amount'
	");
		
	
 	


 	return mysqli_affected_rows($db);
 }


 function tambahorderlines($data){
	global $db;
	$id = htmlspecialchars($data["id"]);
	$product_id = htmlspecialchars($data["product_id"]);
	$qty = htmlspecialchars($data["qty"]);
	$unit_price = htmlspecialchars($data["unit_price"]);
	$sales_amount = htmlspecialchars($data["sales_amount"]);
	$total_amount=$qty * $unit_price;
	
	$query="INSERT INTO purchase_invoice_lines SET
					order_id='$id',
					product_id='$product_id',
					qty='$qty',
					unit_price='$unit_price',
					sales_amount='$sales_amount',
					total_amount='$total_amount'
	";
	mysqli_query($db, $query);
	$update_amount=mysqli_query($db,"UPDATE purchase_invoices SET
					total_amount=total_amount+'$total_amount'
					WHERE id='$id'");
		
	
 	


 	return mysqli_affected_rows($db);
 }
?>
