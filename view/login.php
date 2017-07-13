<?php
include '../common.php';
$prevPage = $_SERVER ['HTTP_REFERER'];
$_SESSION ['prevPage'] = $prevPage;
if (isset($_SESSION['login_user'])) {
	$login_user = $_SESSION['login_user'];
}
if (isset($login_user)) {
	header("Location: ".$domainName."/prjCandle/view/index.php");
}
?>
	<div class="container">
		<div class="row">
			<div class="box">
				<div class="col-lg-12">
					<hr>
					<h2 class="intro-text text-center">
						<strong>로그인</strong>
					</h2>
					<hr>
					<div class="col-md-4 col-md-offset-4">
						<div class="login-panel panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">아이디와 비밀번호를 입력하세요.</h3>
							</div>
							<div class="panel-body">
								<form role="form" action="<?=$domainName?>prjcandle/member/loginOk.php"
									method="post" accept-charset="utf-8">
									<fieldset>
										<div class="form-group">
											<input type="text" name="mem_nickname" class="form-control" placeholder="아이디" autofocus="autofocus">
										</div>
										<div class="form-group">
											<input type="password" name="mem_pw" class="form-control" placeholder="비밀번호">
										</div>
										<div class="form-group">
											<input type="hidden" name="save" value="contact"> <!-- 아이디 저장 기능 사용 할까? -->
											<button type="submit" class="btn btn-lg btn-primary btn-block">로그인</button>
										</div>
									</fieldset>
								</form>
							</div>
							<!-- /.panel-body -->	
						</div>
						<!-- /.login-panel panel panel-default -->
					</div>
					<!-- /.col-md-4 col-md-offset-4 -->
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.row -->
	</div>
    <!-- /.container -->
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
