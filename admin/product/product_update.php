<?php
error_reporting(0);
$no= $_GET['no'];
$code= $_POST['code'];
$name= $_POST['name'];
$price= $_POST['price'];

include '../common.php';
include '../dbConfig.php';

$query = "UPDATE product SET productname='%$name%', productprice='%$price%', productno='%$code%' where productno='%$no%'";
$result= mysqli_query ( $conn, $query );

echo "$query";
 ?>
