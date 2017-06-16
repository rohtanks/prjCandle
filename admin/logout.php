<?php
include_once '../config.php';
session_start(); // 로그아웃을 수행하려면 먼저 세션을 시작해야한다
if (isset($_SESSION['super_user'])) { // 로그인  상태 확인을 위해 세션변수를 확인
	// 세션 배열을 초기화
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) { // 세션 이름으로 된 쿠키를 자동으로 생성해 저장한다고 한다
		// 쿠키 만기 시점을 한 시간 전으로 설정해서 세션 쿠키를 삭제
		setcookie(session_name(), '', time() - 3600);
	}
	// 세션 종료
	session_destroy();
}
header("location: ".$domainName."prjCandle/admin/view/admin.php");
?>
