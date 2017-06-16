<?php
include '../dbConfig.php';
include '../config.php';
// DB연결을 위해 dbConfig.php를 로드

session_start();
// 세션 변수를 사용하기 위해 세션 시작

if (!isset($_POST['ad_id']) || !isset($_POST['ad_pw'])) exit;
// login페이지에서 id 나 pw 변수가 생성되지 않았을 경우 스크립트를 실행하지 않는다
$id = $_POST['ad_id'];
$pw = $_POST['ad_pw'];

$sql_select_pwLevel = "SELECT ad_pw, ad_level FROM admin WHERE ad_id = '".$id."'";
$pwResult = mysqli_query($conn, $sql_select_pwLevel);
$row = mysqli_fetch_row($pwResult);

if ($id === 'admin' && $pw === $row[0]) { // 최초 로그인 시
	$_SESSION['oneTime_user'] = $id;
	header('Location: '.$domainName.'prjCandle/admin/view/register.php'); // 비밀번호 수정을 위해
} elseif (password_verify($pw, $row[0])) {
	$_SESSION['super_user'] = $id;
	$_SESSION['super_level'] = $row[1];
	header('Location: '.$domainName.'prjCandle/admin/view/admin.php');
} else {
	header('Location: '.$domainName.'prjCandle/admin/view/login.php');
}

mysqli_close($conn);
?>