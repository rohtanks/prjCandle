<?php
include '../dbConfig.php';

$inputId = $_POST['id'];

$sql_select_idCheck = "SELECT COUNT(*) FROM member WHERE mem_nickname = '". $inputId ."'";
$result= mysqli_query($conn, $sql_select_idCheck);
$count = mysqli_fetch_row($result);

if ($count[0] >= 1) {
	echo "NO";
} else {
	echo "YES";
}
mysqli_close($conn);
?>