<?php
include '../config.php';
include '../common.php';
$prevPage = $_SERVER["HTTP_REFERER"];
session_start();
$_SESSION['prevPage'] = $prevPage;
?>
<body>
		<div class="row">
				<div class="box">
						<div class="col-lg-12">
								<hr>
								<h2 class="intro-text text-center">
										<strong>로그인</strong>
								</h2>
								<hr>
								<p>아이디와 비밀번호를 입력하세요.</p>

								<form action="<?=$domainName?>prjCandle/member/loginOk.php" method="post"
										accept-charset="utf-8">
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
<!-- /.container -->
<?php
include '../footer.php';
?>

</body>
</html>
