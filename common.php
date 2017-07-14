<?php
include '../config.php';
session_start(); // 여기에 세션을 시작하는 이유는 로그인 페이지에서 common.php를 include하기 때문에 여기서 세션을 시작해줘야 warning이 발생하지 않는다
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<title>노아람캔들</title>
	<!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Custom CSS -->
	<link href="../css/business-casual.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Fonts -->
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
		rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic"
		rel="stylesheet" type="text/css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="brand">
		<a href="<?=$domainName?>prjCandle/view/index.php">노아람캔들</a>
	</div>
	<div class="address-bar">경기도 군포시 송부로</div>
	
	<!-- Navigation -->
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
				<a class="navbar-brand" href="<?=$domainName?>prjCandle/view/index.php">노아람캔들</a> <!-- 모바일 뷰에서 나타나는 메인 링크 -->
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
	            <?php
				if (! isset ( $_SESSION ['login_user'] )) {
				?>
	                <!-- 로그인 전 -->
					<li><a href='<?=$domainName?>prjCandle/product/cart.php'>장바구니</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/product.php'>상품소개</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/list.php'>게시판</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/about.php'>회사소개</a></li>
					<li>
						<form name="form1" style="margin-top: 30px" method="post"
							action="<?=$domainName?>prjCandle/product/product_search.php">
							<input type="text" name="findtext" maxlength="40" size="18">
						</form>
					</li>
					<!-- form1 끝 -->
					<li>
						<a href="javascript:Search()" style="padding-left: 10px"><img src="../img/i_search1.gif" border="0"></a>
					</li>
	            <?php
				} else {
				?>
	              	<!-- 로그인 후 -->
					<li><a href='<?=$domainName?>prjCandle/product/cart.php'>장바구니</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/product.php'>상품소개</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/list.php'>게시판</a></li>
					<li><a href='<?=$domainName?>prjCandle/view/about.php'>회사소개</a></li>
					<li>
						<form name="form1" style="margin-top: 30px" method="post"
							action="<?=$domainName?>prjCandle/product/product_search.php">
							<input type="text" name="findtext" maxlength="40" size="18">
						</form>
					</li>
					<!-- form1 끝 -->
					<li>
						<a href="javascript:Search()" style="padding-left: 10px"><img src="../img/i_search1.gif" border="0"></a>
					</li>
					<font color="#666666">&nbsp <b>Welcome ! &nbsp;<?=$_SESSION ['login_user']?> 고객님.</b></font>
	            <?php
				}
				?>
					<li>
		            <?php
					if (! isset ( $_SESSION ['login_user'] )) {
					?>
			  			<!-- 로그인 전 -->
						<table class="table">
						  <tr>
						  	<td><a href="<?=$domainName?>prjCandle/view/index.php">HOME</a></td>
						  	<td><img src="../img/menu_line.gif" width="11"></td>
						  	<td><a href="<?=$domainName?>prjCandle/view/login.php">로그인</a></td>
						  	<td><img src="../img/menu_line.gif" width="11"></td>
						  	<td><a href="<?=$domainName?>prjCandle/view/register.php">회원가입</a></td>
						  </tr>
						</table>
						<?php
						} else {
						?>
					 <!-- 로그인 후 -->
						<table class="table">
						  <tr>
							<td><a href="<?=$domainName?>prjCandle/view/index.php">HOME</a></td>
							<td><img src="../img/menu_line.gif" width="11"></td>
							<td><a href="<?=$domainName?>prjCandle/member/logout.php">로그아웃</a></td>
						  </tr>
						</table>
					<?php
					}
					?>
					</li>
	            </ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
	</nav>
	<script type="text/javascript">
		function Search() {
			if (!form1.findtext.value) {
				alert("검색할 단어를 입력해주세요");
				return;
			}
			form1.submit();
		}
	</script>