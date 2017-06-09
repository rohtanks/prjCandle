<?php
session_start ();

include '../config.php';
include '../dbConfig.php';

$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>
	<div>
		<table>
			<tr>
				<td align="center">
					<p>글을 삭제하시겠습니까?<p>
				</td>
			</tr>
			<tr>
				<td align="center">
					<form action="<?=$domainName?>prjcandle/board/deleteOK.php?id=<?= $id ?>" method="post">
						<button onclick="history.back()">취소</button>
						<!-- 버튼 누를 시 자바스크립트 실행되어 이전 페이지로 돌아감 -->
						<button type="submit">확인</button>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>