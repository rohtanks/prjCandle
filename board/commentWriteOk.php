<?php
include_once '../dbConfig.php'; // require는 해당 파일의 코드를 현재 파일로 포함시키는 것은 같으나 설정한 위치에 파일이 없으면 fatal error를 뿜는다(include는 warning)

session_start ();

// 원 게시글 번호
$brd_id = $_POST['brd_id'];
if (isset($_SESSION['login_user'])) {
	$co_writer = $_SESSION['login_user'];
}
$co_content = (isset($_POST ['co_content'])) ? $_POST ['co_content'] : null;

$w = '';
$coId = 'null';

// 2Depth & 수정 & 삭제
if(isset($_POST['w'])) {
	$w = $_POST['w'];
	$coId = $_POST['co_id'];
}

if($w !== 'd') { // $w 변수가 d일 경우 $coContent와 $coWriter가 필요 없음.
	$co_content = $_POST['co_content'];
	// 	if($w !== 'u') { // $w 변수가 u일 경우 $coId가 필요 없음.
	// 		$coId = $_POST['coId'];
	// 	}
}

if(empty($w) || $w === 'w') { // $w 변수가 비어있거나 w인 경우
	$msg = '작성';
	$sql = "INSERT INTO comment (brd_id, co_order, co_writer, co_content) VALUES (".$brd_id.", ".$coId.", '".$co_writer."', '".$co_content."')";
	if(empty($w)) { // $w 변수가 비어있다면(1Depth 글 쓰기)
		$result = mysqli_query($conn, $sql);
		
		$co_id = mysqli_insert_id($conn); // 댓글의 깊이를 주기 위해 id가 필요하다
		# The mysqli_insert_id() function returns the id (generated with AUTO_INCREMENT) used in the last query.
		$sql = "UPDATE comment SET co_order = co_id WHERE co_id = ".$co_id;
	}
	
} else if($w === 'm') { // 수정
	$msg = '수정';
	$sql = "UPDATE comment SET co_content = '".$co_content."' WHERE co_id = ".$coId;
	
} else if($w === 'd') { // 삭제
	$msg = '삭제';
	$sql = "DELETE FROM comment WHERE co_id = ".$coId; // TODO 댓글 삭제시 대댓글은 남기는 문제 고려해봐야함
	
} else {
	?>
	<script>
		alert('정상적인 경로를 이용해주세요.');
		history.back();
	</script>
<?php 
	exit(mysqli_error($conn));
}
	
$result = mysqli_query($conn, $sql);
if($result) {
?>
	<script>
		alert('댓글이 정상적으로 <?=$msg?>되었습니다.');
	</script>
<?php
	echo "<meta http-equiv='refresh' content='1; URL=./read.php?id=$brd_id'>";
} else {
?>
	<script>
		alert('댓글 <?=$msg?>에 실패했습니다.');
		history.back();
	</script>
<?php
	exit(mysqli_error($conn));
}
mysqli_close($conn);
?>