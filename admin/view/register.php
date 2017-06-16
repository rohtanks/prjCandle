<?php
session_start ();
include '../../config.php';
// super_user 세션이 있는지부터 확인할 것

?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>
</head>
<body>
	<h2>
		<strong>관리자 계정 등록</strong>
	</h2>
	<?php 
	if (isset ( $_SESSION ['oneTime_user'] )) { // 세션에 있으면 바로 비밀번호를 수정할 수 있게
		$user = $_SESSION ['oneTime_user'];
	?>
	<form id="ad_form1"
		action="<?=$domainName?>prjcandle/admin/registerOk.php?mode=modify" method="post"
		accept-charset="utf-8">
		<dl>
			<dt>
				<label for="ad_id">아이디</label>
			</dt>
			<dd>
				<input type="text" id="ad_id" name="ad_id" value="<?=$user?>" readonly="readonly"/><br>
			</dd>
			<dt>
				<label for="ad_pw">비밀번호</label>
			</dt>
			<dd>
				<input type="password" id="ad_pw" name="ad_pw" />
			</dd>
		</dl>
		<div>
			<button type="submit" id="btn_submit" class="btn btn_submit">변경하기</button>
		</div>
	</form>
	<?php 
	} elseif (isset ( $_SESSION ['super_user'] )) {
		$user = $_SESSION ['super_user'];
	?>
	<form id="ad_form2"
		action="<?=$domainName?>prjcandle/admin/registerOk.php?mode=write" method="post"
		accept-charset="utf-8">
		<dl>
			<dt>
				<label for="ad_id">아이디</label>
			</dt>
			<dd>
				<input type="text" id="ad_id" name="ad_id"/><br>
			</dd>
			<dt>
				<label for="ad_pw">비밀번호</label>
			</dt>
			<dd>
				<input type="password" id="ad_pw" name="ad_pw" />
			</dd>
			<dt>
				<label for="ad_level">권한 등급</label>
			</dt>
			<dd>
				<input type="number" id="ad_level" name="ad_level" min="2" max="3"/> <!-- 1 only admin, 2 관리자 계정 생성만 제한, 3 상품 관리 기능만 -->
			</dd>
		</dl>
		<div>
			<button type="submit" id="btn_submit" class="btn btn_submit">가입하기</button>
			<button onclick="history.back(); return false;">취소</button> <!-- IE에서 button태그의 onclick속성에서 history.back()은 오동작한다
																		 history.back(); return false;라고 한다거나 input태그를 사용하면 정상적으로 작동한다 -->
		</div>
	</form>
	<?php 
	}
	?>
</body>
</html>