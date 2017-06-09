<?php
// DB연결 설정을 위한 파일
$servername = "localhost";
$username = "root";
$password = "autoset";
$dbname = "prjcandle";

$conn = mysqli_connect ( $servername, $username, $password ) or exit("DB connection failed");
mysqli_select_db ( $conn, $dbname) or exit("DB connection failed");
?>
