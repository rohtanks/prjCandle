<?php
include '../dbConfig.php';

// id 파라미터의 값이 없을 경우 0으로 인식을 하기 때문에 이런 처리를 했다
$id = (int)$_GET['id'];
$sql_delete_board = "DELETE FROM board WHERE brd_id = $id";

if (!empty($id)) {
	if (mysqli_query($conn, $sql_delete_board)) {
		header("Location: list.php");
	} else {
		exit(mysqli_error($conn));
	}

} else {
	echo "유효한 값이 아닙니다. 게시판으로 돌아갑니다.";
	echo "<meta http-equiv='refresh' content='1; URL=list.php'>";
}
mysqli_close($conn);

?>