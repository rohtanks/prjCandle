<?php
include '../dbConfig.php';

session_start ();

// mode 프로퍼티를 통해 글 쓰기인지 수정하기인지 알아본다
$mode = $_GET['mode'];

$brd_cate = $_POST ['brd_cate'];
$brd_writer = $_SESSION ['login_user'];
$brd_title = $_POST ['brd_title'];
$brd_content = $_POST ['brd_content'];
if (empty ( $_POST ['brd_photo'] )) {
	$brd_photo = null;
} else {
	$brd_photo = $_POST ['brd_photo'];
}
if (empty ( $_POST ['brd_secret'])) {
	$brd_secret = "0";
} else {
	$brd_secret = $_POST ['brd_secret'];
}

// 글 쓰기
if ($mode == 'write') {
	$sql_insert_board = "INSERT INTO board (brd_cate, brd_writer, brd_title, brd_content,
	brd_photo, brd_secret) VALUES ('" . $brd_cate ."', '" . $brd_writer . "', '" . $brd_title . "',
	'" . $brd_content . "', NULL, '" . $brd_secret . "')";
	
	echo $sql_insert_board;
	
	if (mysqli_query($conn, $sql_insert_board)) {
		// 작성한 글의 뷰 페이지로 리다이렉션 하는 효과를 주기 위한 방법
		// 작성한 글의 brd_id를 구하기 위한 임시 방편
		$sql_select_id = "SELECT brd_id FROM board WHERE brd_writer = '".$brd_writer."' ORDER BY brd_id DESC";
		
		$result_get_id = mysqli_query($conn, $sql_select_id);
		$row = mysqli_fetch_row($result_get_id);
		$read_id = $row[0];
		header("Location: read.php?id=".$read_id);
	} else {
		exit(mysqli_error($conn));
	}

// 수정하기
} else if ($mode == 'modify') {
	$id = (int)$_GET['id'];
	$sql_update_board = "UPDATE board SET brd_cate = '".$brd_cate."', brd_title = '".$brd_title."', brd_content = '".$brd_content."', 
	brd_photo = NULL, brd_secret = '".$brd_secret."' WHERE brd_id = $id";
	if (mysqli_query($conn, $sql_update_board)) {
		echo "<meta http-equiv='refresh' content='1; URL=read.php?id=$id'>";
		#meta 태그 http-equiv의 값을 refresh로 주면 content에 지정해 놓은 초 마다 refresh를 함
		#홈페이지의 주소가 바뀌었을 경우에 사용하는 태그로 1초뒤에 url 속성값으로 지정한 페이지로 이동한다는 의미입니다.
		#이렇게 이동하는 것은 하이퍼링크를 눌러서 이동하는거와는 다른 의미를 갖습니다.
		#하이퍼링크를 누른다는것은 한 페이지를 읽고 있다가 다른 페이지로 이동한다는 의미이지만, <meta> 태그를 이용한 페이지 이동은 http-equiv 속성값을 지정된거와 같이 refresh 한다는 의미입니다.
		#즉 위와 같은 <meta>태그가 입력된 페이지는 읽지 않은걸로 인식하겠다는 의미입니다.
	} else {
		exit(mysqli_error($conn));
	}
}

mysqli_close($conn);
?>