<?php
session_start();
include '../config.php';
include '../dbConfig.php';
include '../common.php';

$login_user = (isset($_SESSION['login_user']) && $_SESSION['login_user']) ? $_SESSION['login_user'] : NULL; // 세션변수가 없을 땐 null로 명시

$id = $_GET ['id'];
if (!isset($_GET['page'])) {
	$page = 1;
} else {
    $page = $_GET ['page'];
}
if (isset($_GET['search_type'])) {
	$search_type = $_GET['search_type']; // 게시판 검색 셀렉트 박스 항목
	$subString .= "&amp;search_type=".$search_type; // 페이지에 붙여넣을 변수, &amp; 는 &(엠퍼샌드)
}
if (isset($_GET['search_text'])) {
	$search_text = $_GET['search_text']; // 게시판 검색어
	$subString .= "&amp;search_text=".$search_text;
}

$sql_select_one = "SELECT * FROM board WHERE brd_id = '" . $id . "'";
$result_one = mysqli_query ( $conn, $sql_select_one );
$row = mysqli_fetch_assoc ( $result_one );
// 글 작성자와 세션 사용자를 비교하기 위한 변수
$writer = $row['brd_writer'];

// 조회수 증가
$sql_update_check = "UPDATE board SET brd_check = brd_check + 1 WHERE brd_id = '". $id ."'"; // TODO 새로고침이나 같은 사용자로 인해 조회수가 중복 증가되는것 방지 필요
mysqli_query($conn, $sql_update_check);
?>

<body>
	<div class="box">
	<table>
		<tr>
			<td colspan="5"><strong><?= $row['brd_title']?></strong></td>
		</tr>
		<tr>
			<td>이름: <?= $row['brd_writer']?></td>
		</tr>
		<tr>
			<td>등록일: <?= $row['brd_created_datetime']?></td>
		</tr>
		<tr>
			<td>조회수: <?= $row['brd_check']?> / 추천수: <?= $row['brd_like']?></td>
		</tr>
		<tr>
			<td align="right">
				<?php
// 				수정하기와 삭제하기 버튼은 세션 사용자와 글 작성자를 비교하여 노출
				if ($login_user == $writer) { // TODO 로그인 하지 않고 글을 볼 땐 어떻게 해야하지? -> 해결(3번째 줄)
				?>
				<a href="<?=$domainName?>prjcandle/view/write.php?id=<?= $id ?>&mode=modify">수정하기</a>
				<a href="<?=$domainName?>prjcandle/board/delete.php?id=<?= $id ?>">삭제하기</a>
				<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td colspan="5"><?= $row['brd_content']?></td>
		</tr>
	</table>
	<div>
		<?php
		if (! isset ( $_SESSION ['login_user'] )) {
		?>
		<!-- 로그인 전 -->
			<a href='<?=$domainName?>prjCandle/view/login.php'>로그인</a>
		<?php
		} else {
		?>
			<a href="<?=$domainName?>prjcandle/view/write.php?mode=write">글쓰기</a>
		<?php 
		}
		?>
		<a href="<?=$domainName?>prjcandle/view/list.php?page=<?= $page ?><?=$subString?>">목록보기</a>
	</div>
	<hr>
<!-- 	댓글 표시 부분 시작 -->
	<?php 
	include_once './comment.php';
	?>
<!-- 	댓글 표시 부분 끝 -->
<!-- 	이전글 다음글 보기 -->
	<?php
	// 이전글 보기 버튼
	// 이전글은 현재 글 이전에 작성된 글
	// 현재 글의 id보다 작은 값들 중 가장 큰 값을 가져오기 위한 query
	$sql_select_prev = "SELECT brd_id FROM board WHERE brd_id < $id ORDER BY brd_id DESC LIMIT 1";
	# order by desc를 하지 않으면 오름차순으로 되기 때문에 현재 id보다 작은 값 중 가장 작은 값을 가져온다
	$result_prev = mysqli_query($conn, $sql_select_prev);
	$prev_id = mysqli_fetch_row($result_prev);
	if ($prev_id[0]) //이전 글이 있을 경우
	{
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$prev_id[0].$subString'>▽이전글</a>&nbsp;&nbsp;";
	}

	// 다음글 보기 버튼
	$sql_select_next = "SELECT brd_id FROM board WHERE brd_id > $id LIMIT 1";
	$result_next = mysqli_query($conn, $sql_select_next);
	$next_id = mysqli_fetch_row($result_next);
	if ($next_id[0]) //다음 글이 있을 경우
	{
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$next_id[0].$subString'>△다음글</a>";
	}
	?>
</div>
<?php
include '../footer.php';
?>
</body>
</html>
