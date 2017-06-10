<?php
if(!isset($_SESSION)){
    session_start();
}
$login_user = $_SESSION['login_user'];

include '../config.php';
include '../dbConfig.php';
include '../common.php';

// mode 프로퍼티를 통해 글 쓰기인지 수정하기인지 알아본다
$mode = $_GET['mode'];
?>
<body>
	<div class="box">
	<div><?php echo $login_user?></div>
	<?php
	// 글 쓰기
	if ($mode == 'write') {
	?>
	<form action="../board/writeOk.php?mode=<?= $mode ?>" method="post"
			accept-charset="utf-8">
		<label>제목</label>
		<input type="text" name="brd_title" /><br>
		<label>분류</label>
		<select name="brd_cate">
			<option value="1">상품문의</option>
			<option value="2">인생상담</option>
			<option value="3">연예상담</option>
		</select><br>
		<label>내용</label>
		<textarea name="brd_content"></textarea><br>
		<label>업로드 파일</label>
		<input type="button" name="brd_photo" value="사진 업로드"/><br>
<!-- 		<input type="button" name="" value="파일 업로드"/><br> -->
		<label>비밀글 여부</label>
		<input type="checkbox" name="brd_secret" value="1"/>비밀글을 위한 체크
		<div>
			<p>
				<button type="submit">작성완료</button><br>
				<!-- 버튼 누를 시 자바스크립트 실행되어 이전 페이지로 돌아감 -->
				<button onclick="history.back(); return false;">취소</button> <!-- IE에서 button태그에서 history.back()은 안먹힘 오동작,
																				history.back()에 return false를 주면 정상 동작
																				input태그는 또 먹힘 -->
			</p>
		</div>
	</form>
	<?php
	// 수정하기
	} else if ($mode == 'modify') {
		$id = $_GET['id'];
		$sql_select_modify = "SELECT * FROM board WHERE brd_id = '".$id."'";
		$result = mysqli_query($conn, $sql_select_modify);
		$row = mysqli_fetch_assoc($result);
	?>
	<form action="<?=$domainName?>prjcandle/board/writeOk.php?id=<?= $id ?>&mode=<?= $mode ?>" method="post"
			accept-charset="utf-8">
		<label>제목</label>
		<input type="text" name="brd_title" value="<?= $row['brd_title'] ?>" /><br>
		<label>분류</label>
		<select name="brd_cate">
			<option value="1">상품문의</option>
			<option value="2">인생상담</option>
			<option value="3">연예상담</option>
		</select><br>
		<label>내용</label>
		<textarea name="brd_content"><?= $row['brd_content'] ?></textarea><br>
		<label>업로드 파일</label>
		<input type="button" name="brd_photo" value="사진 업로드"/><br>
<!-- 		<input type="button" name="" value="파일 업로드"/><br> -->
		<label>비밀글 여부</label>
		<input type="checkbox" name="brd_secret" value="1"/>비밀글을 위한 체크
		<div>
			<p>
				<button type="submit">작성완료</button><br>
				<!-- 버튼 누를 시 자바스크립트 실행되어 이전 페이지로 돌아감 -->
				<button onclick="history.back(); return false;">취소</button>
			</p>
		</div>
	</form>
	<?php
	}
	?>
</div>
<?php
include '../footer.php';
?>
</body>
</html>
