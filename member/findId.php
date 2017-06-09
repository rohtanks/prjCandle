<?php
include '../config.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<!-- 	<div class="inner_myinfo_layer"> TODO 이 레이어가 숨겨져 있다 일치하는 아이디가 없을 때 나타나게 처리 -->
<!--         <div class="layer_head"> -->
<!--             <strong class="screen_out">아이디 찾기 안내 레이어</strong> -->
<!--         </div> -->
<!--         <div class="layer_body"> -->
<!--             <strong class="tit_layer"><em class="emph_info">노아람/notanks@hanmail.net</em> 로 아이디를 찾은 결과, 일치하는 아이디가 없습니다.</strong> -->
<!--             <p class="desc_info">다시 한번 연락처를 정확히 넣어 주시거나, 다른 찾기 방법으로 진행해 주세요.</p> -->

<!--             <div class="btn_process"> -->
<!--                 <button class="btn_find btn_ok" id="userNotFoundOkBtn" type="button"><span class="screen_out">확인</span></button> -->
<!--             </div> -->
<!--         </div> -->
<!--         <div class="layer_foot"> -->
<!--             <button class="btn_find btn_close" type="button">닫기</button> -->
<!--         </div> -->
<!--     </div> -->

	<form id="findIdEmailForm" action="<?=$domainName?>prjcandle/member/findIdOk.php" method="post">
		<div class="desc_involve">
			<div class="box_detail">
				<div class="bg_find bg_data">
					<div class="bg_find inner_bg">
						<label class="lab_g" id="searchNameLabel" for="searchEmailName">이름 또는 닉네임을 입력해 주세요.</label>
						<input name="searchName" class="tf_g" id="searchName" type="text">
					</div>
				</div>
				<p class="desc_add emph_notice" style="display: none;">이름을 입력해 주세요.</p>
			</div>
			<div class="box_detail">
				<div class="bg_find bg_data">
					<div class="bg_find inner_bg">
						<label class="lab_g" id="searchEmailLabel" for="searchEmail">이메일 주소 전체를 입력해 주세요.</label>
						<input name="searchEmail" class="tf_g" id="searchEmail" type="text" value="">
					</div>
				</div>
				<p class="desc_add emph_notice" style="display: none;">이메일 주소를 정확하게 입력해 주세요</p>
				<button class="btn_find btn_next" type="submit">다음단계</button>
			</div>
		</div>
	</form>
</body>
</html>
