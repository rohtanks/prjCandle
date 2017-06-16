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
	// 회원가입 페이지에서 로그인을 할 경우 세션이 부여됐음에도 직전 페이지인 회원가입 페이지로 돌아가는 것을 방지하기 위해
	// 세션이 부여되었다면 직전 작업페이지가 회원가입 페이지에 한해 메인 페이지로 보냄
	// TODO register.php에서 돌리는 방법과 이 방법 둘 중 하나 테스트 필요
	if ($prevPage == "http://localhost/prjCandle/view/register.php") {
		header("Location: ../view/index.php");
	} else {
  		header("Location: ".$prevPage);
	}
} else {
	header("Location: ../view/login.php");
}
?>