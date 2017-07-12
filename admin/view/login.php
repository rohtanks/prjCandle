<?php
include '../../config.php';
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		
	<title>노아람캔들 Admin - login을 해라</title>	
	
	<!-- Bootstrap Core CSS -->
	<link href="/prjCandle/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
	<link href="/prjCandle/admin/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
	<link href="/prjCandle/admin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
	<link href="/prjCandle/admin/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<?php 
	if (isset($_SESSION['super_user'])) { // 로그인 상태라면 굳이 여기로 접근할 필요가 없다
		echo "유효한 값이 아닙니다. 이전 페이지로 돌아갑니다.";
		echo "<meta http-equiv='refresh' content='1; URL=admin.php'>";
	} else {
	?>
	<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">관리자 아이디와 비밀번호를 입력하세요.</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?=$domainName?>prjcandle/admin/loginOk.php" method="post" accept-charset="utf-8">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="아이디" name="ad_id" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="비밀번호" name="ad_pw" type="password">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">로그인</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php 
	}
	?>
	
    <!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.min.js"></script>

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