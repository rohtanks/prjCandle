<?php
session_start();
include_once '../../config.php';

if (!isset($_SESSION['super_user'])) {
	header('Location: '.$domainName.'prjCandle/admin/view/login.php');
}
if (isset($_SESSION['super_level'])) {
	$level = $_SESSION['super_level'];
}
	
echo "레벨 - ".$level."인 ".$_SESSION['super_user']."님 반갑습니다.";
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php 
	if ($level == 1) {
	?>
	<a href="<?=$domainName?>prjCandle/admin/view/register.php">계정 생성</a><br> <!-- 관리자 계정 생성은 오로지 레벨 1의 관리자만 가능 -->
	<?php 
	}
	if ($level <= 2) {
	?>
	<a href="<?=$domainName?>prjCandle/admin/view/member.php">회원 관리</a>
	<a href="<?=$domainName?>prjCandle/admin/view/board.php">게시판 관리</a>
	<?php 
	}
	?>
	<a href="<?=$domainName?>prjCandle/admin/view/product.php">상품 관리</a>
	<a href="<?=$domainName?>prjCandle/admin/logout.php">로그아웃</a>
</body>
</html>