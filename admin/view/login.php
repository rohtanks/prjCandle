<?php
include '../../config.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
	<div class="box">
		<div class="col-lg-12">
			<hr>
			<h2 class="intro-text text-center">
				<strong>로그인</strong>
			</h2>
			<hr>
			<p>관리자 아이디와 비밀번호를 입력하세요.</p>

			<form action="<?=$domainName?>prjcandle/admin/loginOk.php"
				method="post" accept-charset="utf-8">
				<div class="row">
					<div class="form-group col-lg-4">
						<label>아이디</label>
						<input type="text" name="ad_id" class="form-control">
					</div>
					<div class="form-group col-lg-4">
						<label>비밀번호</label>
						<input type="password" name="ad_pw" class="form-control">
					</div>
					<div class="form-group col-lg-12">
						<input type="hidden" name="save" value="contact">
						<button type="submit" class="btn btn-default">로그인</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
// 엔터키 폼 전송 방지 시작
$(function() {
	$("input[type='text']").keydown(function(event) {
		if (event.keyCode == 13)
			return false;
	});
	$("input[type='password']").keydown(function(event) { // 패스워드 입력시 스페이스바 안 먹히게
		if (event.keyCode == 32)
			return false;
	});
});
// 엔터키 폼 전송 방지 끝
</script>
</body>
</html>