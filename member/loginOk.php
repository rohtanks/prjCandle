<?php
include '../dbConfig.php';
// DB연결을 위해 dbConfig.php를 로드

session_start();
// 세션 변수를 사용하기 위해 세션 시작

if (!isset($_POST['mem_nickname']) || !isset($_POST['mem_pw'])) exit;
// login페이지에서 nickname 이나 pw 변수가 생성되지 않았을 경우 스크립트를 실행하지 않는다
$session_id = $_POST['mem_nickname'];
$session_pw = $_POST['mem_pw'];
$prevPage = $_SESSION['prevPage'];
// password_verify($session_pw, $hash);

$sql_select_pw = "SELECT mem_pw FROM member WHERE mem_nickname = '".$session_id."'";
$pwResult = mysqli_query($conn, $sql_select_pw);
$row = mysqli_fetch_row($pwResult);

if (password_verify($session_pw, $row[0])) {
	$_SESSION['login_user'] = $session_id;
  header('location: '.$prevPage);
} else {
	header("Location: ../view/login.php");
}
?>
