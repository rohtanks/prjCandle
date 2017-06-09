<?php
include '../config.php';
include '../dbConfig.php';

$name = $_POST ['mem_name'];
$nickname = $_POST ['mem_nickname'];
$pw = $_POST ['mem_pw'];
$phoneNum = $_POST ['mem_phoneNum'];
$email = $_POST ['mem_email'];
$addr = $_POST ['mem_addr'];

// 비밀번호 암호화(bcrypt)
$hash = password_hash($pw, PASSWORD_DEFAULT); // 비밀번호 해쉬 생성, password_default - it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).

$sql_insert_member = "INSERT INTO member(mem_name, mem_nickname, mem_email, mem_pw, mem_phoneNum, mem_addr)
VALUES('" . $name . "', '" . $nickname . "', '" . $email . "', '" . $hash. "', '" . $phoneNum . "', '" . $addr . "')";

if (mysqli_query ( $conn, $sql_insert_member )) {
	header("Location: ". $domainName. "prjcandle/view/index.php");
} else {
	exit(mysqli_error($conn));
}

// $sql_select = "SELECT * FROM member";
// $result = mysqli_query ( $conn, $sql_select );

// while ( $row = mysqli_fetch_assoc ( $result ) ) {
// 	echo $row ['name'] . "<br>";
// 	echo $row ['nickname'] . "<br>";
// 	echo $row ['email'] . "<br>";
// 	echo $row ['pw'] . "<br>";
// 	echo $row ['phone'] . "<br>";
// 	echo $row ['addr'] . "<br>";
// }

?>
