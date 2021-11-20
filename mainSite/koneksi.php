<?php
session_start();
ob_start();
$db=mysqli_connect('localhost','root','','project_kp');

class BASEURL {
	const BASE_URL = "http://localhost/warung_zikry";
}
?>