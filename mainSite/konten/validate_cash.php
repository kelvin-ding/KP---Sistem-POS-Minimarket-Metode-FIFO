<?php
$id=$_GET['id'];
     $query= mysqli_query($db,"UPDATE form_cashes SET status='Validated', updated_at='$time_validate' WHERE id='$id'");
     
     $selectfc=mysqli_query($db,"SELECT date, type, amount FROM form_cashes where id='$id'");
     $data=mysqli_fetch_array($selectfc);
     $type=$data['type'];
     $date=$data['date'];
     $amount=$data['amount'];

     $cash=mysqli_query($db,"SELECT latest_amount FROM cashes WHERE is_latest='1'");
     $d=mysqli_fetch_array($cash);
     if(empty($d['latest_amount'])){
        $current_amount=0;
     }else{
        $current_amount=$d['latest_amount'];
     }



     if($type=='Deposit'){
        $latest_amount=$current_amount+$amount;
        mysqli_query($db,"UPDATE cashes SET is_latest=0");
        mysqli_query($db,"INSERT INTO cashes SET date='$date', current_amount='$current_amount', amount_keyin='$amount', latest_amount='$latest_amount', form_id='$id', is_latest='1' ");
     }else if($type=='Withdraw'){
        $latest_amount=$current_amount-$amount;
        mysqli_query($db,"UPDATE cashes SET is_latest=0");
        mysqli_query($db,"INSERT INTO cashes SET date='$date', current_amount='$current_amount', amount_keyin='$amount', latest_amount='$latest_amount', form_id='$id', is_latest='1' ");
     }
 	echo "
	<script>
		document.location.href = 'data_kas';
	</script>
	";
?>