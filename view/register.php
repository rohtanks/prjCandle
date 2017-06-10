<?php
include '../config.php';
include '../common.php';
?>
  <body>
<script src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>

  <!-- 추후 css로 이동 -->
  <style type="text/css">
  body {
  	text-align: center;
  }

  h1 {
  	text-align: center;
  }

  body .layerbox#register_auth div.wrapper div.body dl.form1 dd input.text
  	{
  	width: 260px;
  	margin-right: auto;
  	padding: 5px;
  	font-size: 1.2em;
  }

  html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p,
  	blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn,
  	em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var,
  	b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend,
  	table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas,
  	details, figcaption, figure, footer, header, hgroup, menu, nav, section,
  	summary, time, mark, audio, video {
  	margin: 0;
  	padiing: 0;
  	border: 0;
  	outline: 0;
  	font-size: 100%;
  	vertical-align: baseline;
  }

  body .layerbox#register_auth div.wrapper div.body dl.form1 dt {
  	text-align: left;
  	font-size: 11px;
  	margin: 15px 0 5px 0;
  	line-height: 11px;
  }

  body .layerbox#register_auth div.wrapper div.body dl.form1 dd {
  	text-align: left;
  }

  body .layerbox#register_auth div.wrapper div.body dl.form1 dd p.notice {
  	display: inline-block;
  	text-align: right;
  	font-size: 11px;
  	margin-left: 15px;
  	padding-left: 25px;
  }

  body .layerbox#register_auth div.wrapper div.body dl.form1 dd span {
  	font-size: 11px;
  }
  </style>
<script type="text/javascript">
// 필수 입력 체크 시작
	$(function(){ // $(document).ready(function(){ 과 같다 모든 html 페이지가 화면에 뿌려지고 나서 저 ready안에 서술된 이벤트들이 동작준비를 한다
		var inputName = $('#mem_name');
		var nameCheckMsg = $('#nameCheck_msg');
		var inputId = $('#mem_nickname');
		var idCheckMsg = $('#idCheck_msg');
		var inputPw = $('#mem_pw');
		var pwCheckMsg = $('#pwCheck_msg');
		var inputPw2 = $('#mem_pw2');
		var inputPhoneNum = $('#mem_phoneNum');
		var phoneNumCheckMsg = $('#phoneNumCheck_msg');
		var inputEmail = $('#mem_email');
		var emailCheckMsg = $('#emailCheck_msg');
		var btnAddr = $('#btn_addr');
		var sumAddrTxt = $('#sumAddr_txt');

		// 주의 자바스크립트 1.1 이하 버전에서는 정규표현식을 사용할 수 없다
		var pattern_valName = new RegExp(/[가-힣A-Za-z]$/); // 한글과 영문 외엔 입력 방지 위해 띄어쓰기 가능 단, 문자 뒤의 공백은 안됨
		var pattern_valHGName = /^[가-힣]$/; // TODO 한글 이름은 띄어쓰기가 안되게 처리하고 싶다
		var pattern_valId = /^[a-z0-9_]{4,}$/; // 영문 소문자가 아니거나 숫자, _ 가 아닌것들 표현 정규표현식,  new RegExp()로 객체 생성을 안해줘도 정상 작동
		var pattern_onlyNumber = new RegExp(/^[0-9]+$/); // 숫자로 시작해서 숫자로 끝난다  + 는 1회 이상 반복의 정규표현식
		var pattern_valPw = /(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^*+=-]){8,}/; // 적어도 소문자 하나, 숫자 하나, 특수문자 하나가 포함되어 있는 8자 이상 문자열
		var pattern_noHyphenNum = /^01([0|1|6|7|8|9]?)?([0-9]{3,4})?([0-9]{4})$/;
		var pattern_valEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

		var form = $('#mem_form');
		var btn_submit = $('#btn_submit');
		var nameFlag = 0, idFlag = 0, pwFlag = 0, pw2Flag = 0, phoneNumFlag = 0, emailFlag = 0, addrFlag = 0; // 각 유효성 체크가 성공했는지 판단하기 위한 변수

		// 이름 유효성 체크 시작
		inputName.blur(function check_valName(){
			if (inputName.val().trim() == "") { // 스페이스바만 눌렀을 경우를 확인하기 위해 trim() 사용
				nameCheckMsg.html('이름을 입력해 주세요.');
				nameFlag = 0;
				return false;
			} else if (!pattern_valName.test(inputName.val())) {
				nameCheckMsg.html('사용할 수 없는 문자가 있어요. 한글(성과 이름을 공백없이 입력) 또는 영문만 입력해 주세요.');
				nameFlag = 0;
				return false;
			} /* else if (pattern_valHGName.test(inputName.val())) {
// 				if (pattern_valHGNamet.test(inputName.val())) {
// 					nameCheckMsg.html('한글(성과 이름을 공백없이 입력) 입력해 주세요.');

// 				}
				return false;
			} */ else {
				nameFlag = 1;
				nameCheckMsg.html('');
			}
		});
		// 이름 유효성 체크 끝
		// ID 유효성 체크 시작
		inputId.blur(function check_valId(){ // keyup 으로 했을 경우 조건을 충족하지 못했을 경우에도 입력 바로 후에 사용 가능한 아이디로 바뀜 그래서 blur로 대체
			var spaceCheck = inputId.val().indexOf(" ");

			if (inputId.val().trim() == "") { // 스페이스바만 눌렀을 경우를 확인하기 위해 trim() 사용
				idCheckMsg.html('아이디를 입력해 주세요.');
				idFlag = 0;
				//inputId.focus(); // TODO 포커스 대체품을 찾아야한다
				return false;
			} else if (inputId.val().length < 4) {
				idCheckMsg.html('조금 더! 아이디는 4자 이상이에요!');
				idFlag = 0;
				return false;
			} else if (spaceCheck != -1) { // 입력 내용에 공백이 없을 경우 -1을 반환, IE에서 includes()를 지원하지 않는 이슈 발생 indexOf로 대체함
				idCheckMsg.html('아이디에 공백이 있습니다.');
				idFlag = 0;
				return false;
			} else if (pattern_onlyNumber.test(inputId.val())) { // 숫자만 입력했을 경우
				idCheckMsg.html('숫자로 된 아이디는 사용할 수 없어요. 영문 소문자를 추가해서 다시 입력해 주세요.');
				idFlag = 0;
				return false;
			} else if (!pattern_valId.test(inputId.val())) { // 영문 소문자, 숫자, _ 이외의 문자를 입력했을 경우
				idCheckMsg.html('영문 소문자와 숫자 또는 "_"기호 조합으로 입력하세요.');
				idFlag = 0;
				return false;
			} else {
			    $.ajax({
			     	type: "POST",
			     	url: "../member/idCheck.php", // 이페이지에서 중복체크를 한다
			     	data: {"id":inputId.val()}, // idCheck.php에 id 값을 보낸다
			     	success: function(data){
						console.log(data);
						if (data == "NO") {
							idCheckMsg.html('이미 사용된 아이디가 있습니다. 다른 아이디를 입력해 주세요.');
							idFlag = 0;
						} else {
							idCheckMsg.html('사용 가능한 아이디입니다.');
							idFlag = 1;
						}
			     	}
			    });
			}
	    });
		// ID 유효성 체크 끝
		// 비밀번호 유효성 체크 시작
		inputPw.keyup(function check_valPw(){ // keyup 함수는 키가 입력되는 순간 작동
			var checkEnglish = inputPw.val().search(/[a-z]/gi);
			var checkSpecial = inputPw.val().search(/[!@#$%^&*+=-]/g);

			if (!inputPw.val()) { // empty
				pwCheckMsg.html('');
				pwFlag = 0;
				return false;
			} else if (inputPw.val().length < 8) {
				pwCheckMsg.html('조금 더! 비밀번호는 8자 이상이에요!');
				console.log(inputPw.val());
				pwFlag = 0;
				return false;
			} else if (pattern_onlyNumber.test(inputPw.val())) {
				pwCheckMsg.html('숫자로 된 비밀번호는 사용할 수 없어요! 영문자, 특수문자를 함께 입력해 주세요.');
				console.log(inputPw.val());
				pwFlag = 0;
				return false;
			} else if (checkEnglish <0 || checkSpecial <0) {
				pwCheckMsg.html('숫자와 영문자, 특수문자를 모두 사용해야 합니다.');
				console.log(inputPw.val());
				pwFlag = 0;
				return false;
			} /* else if (inputPw.val().search(inputId.val()) > -1) { // TODO search는 몇번째 인덱스에서 검색됐는지 반환, 문제가 많아서 잠시 보류
				pwCheckMsg.html('비밀번호에 아이디가 포함됐습니다.');
				console.log(inputPw.val().search(inputId.val()));
				return false;
			} */ else if (pattern_valPw.test(inputPw.val())) {
				pwCheckMsg.html('사용가능');
				console.log(inputPw.val());
				pwFlag = 1;
			}
		});
		// 비밀번호 유효성 체크 끝
		// 비밀번호 확인 체크 시작
		inputPw2.blur(function check_valPw2(){ // TODO 비밀번호 확인을 먼저 입력하고 비밀번호를 입력할 시 일치되지 않는 문제 해결해야 함
			if (inputPw.val() != inputPw2.val()) {
				console.log(inputPw2.val());
				console.log('불일치');
				pw2Flag = 0;
				return false;
			} else {
				console.log('일치');
				pw2Flag = 1;
			}
		});
		// 비밀번호 확인 체크 끝
		// 휴대폰 번호 유효성 체크 시작
		inputPhoneNum.blur(function check_valPhoneNum(){
			var hyphenCheck = inputPhoneNum.val().indexOf("-");
			var nonHyphenNum = inputPhoneNum.val().replace(/-/gi, ''); // 하이픈 제거
			console.log(hyphenCheck);
			if (hyphenCheck > -1) { // inputPhoneNum에 하이픈이 있을 경우
				console.log(nonHyphenNum);
				if (nonHyphenNum.trim() == "") {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('휴대폰 번호를 입력해 주세요.');
					return false;
				} else if (!pattern_noHyphenNum.test(nonHyphenNum)) {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('잘못된 휴대폰 번호 입니다. 휴대폰 번호를 확인한 후 다시 입력해 주세요.');
					return false;
				} else if (!pattern_onlyNumber.test(nonHyphenNum)) {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('잘못된 휴대폰 번호 입니다. 휴대폰 번호를 확인한 후 다시 입력해 주세요.');
					return false;
				} else {
					phoneNumFlag = 1;
					inputPhoneNum.val(nonHyphenNum); // 하이픈 제거한 번호를 inputPhoneNum에 입력
					phoneNumCheckMsg.html('');
					console.log('정상적인 휴대폰 번호');
				}
			} else { // inputPhoneNum에 하이픈이 없을 경우
				if (inputPhoneNum.val().trim() == "") {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('휴대폰 번호를 입력해 주세요.');
					return false;
				} else if (!pattern_noHyphenNum.test(inputPhoneNum.val())) {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('잘못된 휴대폰 번호 입니다. 휴대폰 번호를 확인한 후 다시 입력해 주세요.');
					return false;
				} else if (!pattern_onlyNumber.test(inputPhoneNum.val())) {
					phoneNumFlag = 0;
					phoneNumCheckMsg.html('잘못된 휴대폰 번호 입니다. 휴대폰 번호를 확인한 후 다시 입력해 주세요.');
					return false;
				} else {
					phoneNumFlag = 1;
					phoneNumCheckMsg.html('');
					console.log('정상적인 휴대폰 번호');
				}
			}
		});
		// 휴대폰 번호 유효성 체크 끝
		// 이메일 유효성 체크 시작
		inputEmail.blur(function check_valEmail(){
			if (inputEmail.val().trim() == "") {
				emailCheckMsg.html('이메일을 입력해 주세요.');
				emailFlag = 0;
				return false;
			} else if (!pattern_valEmail.test(inputEmail.val())) {
				emailCheckMsg.html('이메일 주소 형식이 아닙니다. 본인확인이 가능한 이메일 주소를 입력해 주세요.');
				emailFlag = 0;
				return false;
			} else {
				emailCheckMsg.html('');
				emailFlag = 1;
			}
		});
		// 이메일 유효성 체크 끝
		// 주소 입력값 유무 확인 시작
		btnAddr.click(function check_isAddr(){
			if (sumAddrTxt.val()) {
				addrFlag = 1;
				console.log(sumAddrTxt.val());
			}
		});
		// 주소 입력값 유무 확인 끝
		$('#test').click(function(){
			console.log('nameFlag : '+nameFlag);
			console.log('idFlag : '+idFlag);
			console.log('pwFlag : '+pwFlag);
			console.log('pw2Flag : '+pw2Flag);
			console.log('phoneNumFlag : '+phoneNumFlag);
			console.log('emailFlag : '+emailFlag);
			console.log('addrFlag : '+addrFlag);
		});
		// 폼 전송 체크 시작
		btn_submit.click(function(){
			if (nameFlag && idFlag && pwFlag && pw2Flag && phoneNumFlag && emailFlag && addrFlag == 1) { // 모든 유효성 체크가 성공해야 submit을 할 수 있다
				form.submit();
			} else {
				// TODO 유효성 체크가 성공하지 않은 input 태그의 테두리 색 변화
			}
		});
		// 폼 전송 체크 끝
    });
// 필수 입력 체크 끝
// 엔터키 폼 전송 방지 시작
	$(function() {
		$("input[type='text'], input[type='password'], input[type='email']").keydown(function(event) { // 특정 태그의 속성 선택 시 이렇게 사용
			if (event.keyCode == 13)
				return false;
		});
		$("input[type='password']").keydown(function(event) { // 추가로 패스워드 입력시 스페이스바 안 먹히게
			if (event.keyCode == 32)
				return false;
		});
	});
// 엔터키 폼 전송 방지 끝

</script>
<div class="row">
					<div class="box">
							<div class="col-lg-12">
									<hr>
									<h2 class="intro-text text-center">
											<strong>회원가입</strong>
									</h2>
												<hr>
	<div class="entry-area">
		<div class="layerbox" id="register_auth" style="width: 500px;">
			<div class="wrapper table">
				<div class="header">
				</div>
				<div class="body">

					<form id="mem_form" action="<?=$domainName?>prjcandle/member/registerOk.php"
						method="post" accept-charset="utf-8">
						<dl class="form1">
							<!-- description list dt(defines terms/names) dd(describes each term/name) 태그와 함께 사용 -->
							<p>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> 는 필수 입력 항목입니다.
							</p>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_name">이름</label>
							</dt>
							<dd>
								<input type="text" id="mem_name" name="mem_name" /><br>
								<span id="nameCheck_msg" class="txt_message"></span>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_nickname">아이디</label>
							</dt>
							<dd>
								<input type="text" id="mem_nickname" name="mem_nickname" />
								<p class="notice" id="msg_mb_id">영문자, 숫자, _ 만 입력 가능.</p>
								<br> <span id="idCheck_msg" class="txt_message"></span>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_pw">비밀번호</label>
							</dt>
							<dd>
								<input type="password" id="mem_pw" name="mem_pw" />
								<p class="notice" id="msg_mb_pw">비밀번호는 8글자 이상 적어도 한개 이상의 영대소문자, 숫자, 특수문자(!@#$%^&*+=-)를 입력하세요.</p><br>
								<span id="pwCheck_msg" class="txt_message"></span>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="pw2">비밀번호 확인</label>
							</dt>
							<dd>
								<input type="password" id="mem_pw2" name="mem_pw2" />
								<p class="notice" id="msg_mb_pw_re">비밀번호를 다시한번 입력하세요.</p>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_phoneNum">휴대폰 번호</label>
							</dt>
							<dd>
								<input type="text" id="mem_phoneNum" name="mem_phoneNum" /><br>
								<span id="phoneNumCheck_msg" class="txt_message"></span>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_email">이메일 주소</label>
							</dt>
							<dd>
								<input type="email" id="mem_email" name="mem_email" /><br>
								<span id="emailCheck_msg" class="txt_message"></span>
							</dd>
							<dt>
								<img src="<?=$domainName?>prjcandle/img/check_icon.png"
									height="15px"> <label for="mem_addr">주소</label>
							</dt>
							<dd>
								<input type="text" id="mem_postcode" readonly="readonly"
									placeholder="우편번호"> <input type="button"
									onclick="execDaumPostcode()" value="우편번호 찾기"><br> <input
									type="text" id="mem_address" readonly="readonly"
									placeholder="주소"> <input type="text" id="mem_address2"
									placeholder="상세주소">
								<input type="button" id="btn_addr" onclick="sumAddress()" value="주소 입력하기">
								<input type="text" id="sumAddr_txt" name="mem_addr">

								<input type="button" id="test" value="test">
							</dd>
						</dl>
						<div class="btns">
							<p>
								<button type="button" id="btn_submit" class="btn btn_submit">가입하기</button>
							</p>
						</div>
					</form>
				</div>

				<div class="footer">
					<a
						href="https://opentutorials.org/auth?mode=forget&amp;returnURL=https%3A%2F%2Fopentutorials.org%2Fcourse%2F2598">비밀번호
						찾기</a> | <a
						href="<?=$domainName?>prjcandle/member/login.php">로그인</a>
				</div>
			</div>
		</div>
	</div>
	<!-- 	다음 주소 검색 서비스 시작 -->
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script type="text/javascript">
	    function execDaumPostcode() {
	        new daum.Postcode({
	            oncomplete: function(data) {
	            	// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

	                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
	                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
	                var fullAddr = ''; // 최종 주소 변수
	                var extraAddr = ''; // 조합형 주소 변수

	                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
	                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
	                    fullAddr = data.roadAddress;

	                } else { // 사용자가 지번 주소를 선택했을 경우(J)
	                    fullAddr = data.jibunAddress;
	                }

	                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
	                if(data.userSelectedType === 'R'){
	                    //법정동명이 있을 경우 추가한다.
	                    if(data.bname !== ''){
	                        extraAddr += data.bname;
	                    }
	                    // 건물명이 있을 경우 추가한다.
	                    if(data.buildingName !== ''){
	                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
	                    }
	                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
	                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
	                }

	                // 우편번호와 주소 정보를 해당 필드에 넣는다.
	                document.getElementById('mem_postcode').value = data.zonecode; //5자리 새우편번호 사용
	                document.getElementById('mem_address').value = fullAddr;

	                // 커서를 상세주소 필드로 이동한다.
	                document.getElementById('mem_address2').focus();
	            }
	        }).open();
	    }
	</script>
	<!-- 	다음 주소 검색 서비스 끝 -->
	<script type="text/javascript">
		function sumAddress() {
			if (!document.getElementById('mem_address2').value) {
				alert('상세주소를 입력해 주세요.');
			} else {
				var address = "";
				address = document.getElementById('mem_postcode').value + " " +
				document.getElementById('mem_address').value + " " +
				document.getElementById('mem_address2').value;
				document.getElementById('sumAddr_txt').value = address;
			}
		}
	</script>
  <?php
  include '../footer.php';
  ?>
</body>
</html>
