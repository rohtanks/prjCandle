<?php
include '../config.php';
include '../common.php';
$prevPage = $_SERVER ['HTTP_REFERER'];
if(!isset($_SESSION)){
     session_start();
} 
$_SESSION ['prevPage'] = $prevPage;
if (isset($_SESSION['login_user'])) {
	$login_user = $_SESSION['login_user'];
}
if (isset($login_user)) {
	header("Location: ".$domainName."/prjCandle/view/index.php");
}
?>
<div class="row">
	<div class="box">
		<div class="col-lg-12">
			<hr>
			<h2 class="intro-text text-center">
				<strong>로그인</strong>
			</h2>
			<hr>
			<p>아이디와 비밀번호를 입력하세요.</p>

			<form action="<?=$domainName?>prjcandle/member/loginOk.php"
				method="post" accept-charset="utf-8">
				<div class="row">
					<div class="form-group col-lg-4">
						<label>아이디</label>
						<input type="text" name="mem_nickname" class="form-control">
					</div>
					<div class="form-group col-lg-4">
						<label>비밀번호</label>
						<input type="password" name="mem_pw" class="form-control">
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
<?php
include '../footer.php';
?>
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
