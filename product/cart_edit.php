<?php
if(!isset($_SESSION)){
     session_start();
}
include '../config.php';
include '../common.php';
include '../dbConfig.php';

$no= $_POST['no'];
$opts1= $_POST['opts1'];
$opts2= $_POST['opts2'];
$num= $_POST['num'];

$query = "SELECT * from product where productno like '%$no%'";
$result = mysqli_query ( $conn, $query );
$row = mysqli_fetch_array( $result );
?>
