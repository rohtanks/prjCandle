<?php
include '../config.php';
include '../dbConfig.php';

session_start();

if (!isset($_POST['ad_id']) || !isset($_POST['ad_pw'])) exit;

$mode = $_GET['mode'];

$id = $_POST ['ad_id'];
$pw = $_POST ['ad_pw'];
if (isset($_POST ['ad_level']))
	$level = $_POST ['ad_level'];

// 비밀번호 암호화(bcrypt)
$hash = password_hash($pw, PASSWORD_DEFAULT); // password_default - it is recommended to store the result in a database column that can expand beyond 60 characters (255 characters would be a good choice).

if ($mode == 'modify') {
	$sql_update_admin = "UPDATE admin SET ad_pw = '". $hash ."' WHERE ad_id = '". $id ."'";
	if (mysqli_query($conn, $sql_update_admin)) {
		echo "<p>비밀번호가 정상적으로 수정되었습니다.</p>";
		$_SESSION = array(); // oneTime_user를 없애기 위해 세션변수 초기화
		$url = $domainName."prjCandle/admin/view/login.php";
		echo "<meta http-equiv='refresh' content='1; URL=$url'>";
	} else {
		exit(mysqli_error($conn));
	}
} elseif ($mode == 'write') {
	$sql_insert_admin = "INSERT INTO admin VALUES ('" . $id ."', '" . $hash . "', '" . $level . "')";
	if (mysqli_query($conn, $sql_insert_admin)) {
		echo "<p>관리자 계정이 정상적으로 생성되었습니다.</p>";
		$_SESSION = array(); // admin 계정의 세션을 초기화(url 직접 입력을 통해 admin.php로 접근하는 것을 막기 위해)
		$url = $domainName."prjCandle/admin/view/login.php";
		echo "<meta http-equiv='refresh' content='1; URL=$url'>";
	} else {
		exit(mysqli_error($conn));
	}
}
mysqli_close($conn);
?>
