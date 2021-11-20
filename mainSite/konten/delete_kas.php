<?php
$id = $_GET["id"];

$query=mysqli_query($db,"SELECT status FROM form_cashes WHERE id='$id' LIMIT 1");
$data=mysqli_fetch_array($query);

$status=$data['status'];
	if($status=='Validated'){
		echo "
		<script>
			alert('Validated Form tidak dapat dihapus')
			document.location.href = 'data_kas';
		</script>
		";
	}else{
		mysqli_query($db, "DELETE FROM form_cashes WHERE id = $id");
	echo "
	<script>
		document.location.href = 'data_kas';
	</script>
	";
	}


?>