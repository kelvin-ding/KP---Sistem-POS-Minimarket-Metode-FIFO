<?php
if(isset($_POST['login'])){
	include "mainSite/koneksi.php";

	$username=$_POST['username'];
	$password=md5($_POST['password']);
	
	$query= mysqli_query($db, "SELECT * FROM user WHERE username='$username'");
	$data=mysqli_fetch_array($query);
	$num=mysqli_num_rows($query);

    if($num>0){
        if($password==$data['password']){
            if($data['level']=='admin'){
                $_SESSION['id']=$data['id'];
                $_SESSION['nama']=$data['nama'];
                echo "<script>alert('Welcome Admin'); document.location='mainSite/';</script>";
            }else if($data['level']=='owner'){
                $_SESSION['id']=$data['id'];
                $_SESSION['nama']=$data['nama'];
                echo "<script>alert('Welcome Owner'); document.location='mainSite/';</script>";
            }else if ($$data['level']=='kasir'){
                $_SESSION['id']=$data['id'];
                $_SESSION['nama']=$data['nama'];
                echo "<script>alert('Welcome Kasir'); document.location='mainSite/';</script>";
            }
            
        }else{
            echo "<script>alert('Username / Password anda salah'); document.location='index.php';</script>";
        }
    }else{
        echo "<script>alert('Username tidak tersedia');document.location='index.php'; </script>";

    }
}else{
echo "<script>alert('Mohon masukin username dan password');document.location='index.php'; </script>";


}
?>
