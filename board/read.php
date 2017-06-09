<?php
session_start();
$login_user = $_SESSION['login_user'];
include '../config.php';
include '../dbConfig.php';
include '../common.php';

$id = $_GET ['id'];
if (!isset($_GET['page'])) {
	$page = 1;
} else {
    $page = $_GET ['page'];
}

$sql_select_one = "SELECT * FROM board WHERE brd_id = '" . $id . "'";
$result_one = mysqli_query ( $conn, $sql_select_one );
$row = mysqli_fetch_assoc ( $result_one );

// 글 작성자와 세션 사용자를 비교하기 위한 변수
$writer = $row['brd_writer'];
?>

<body>
	<div class="box">
	<table>
		<tr>
			<td>
				<?php
// 				수정하기와 삭제하기 버튼은 세션 사용자와 글 작성자를 비교하여 노출
				if ($login_user == $writer) {
				?>
				<a href="<?=$domainName?>prjcandle/board/write.php?id=<?= $id ?>&mode=modify">수정하기</a>
				<a href="<?=$domainName?>prjcandle/board/delete.php?id=<?= $id ?>">삭제하기</a>
				<?php
				}
				?>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td colspan="2"><strong><?= $row['brd_title']?></strong></td>
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
			<td colspan="2"><?= $row['brd_content']?></td>
		</tr>
	</table>
	<table>
		<?php
		if (! isset ( $_SESSION ['login_user'] )) {
		?>
		<!-- 로그인 전 -->
				<a href='<?=$domainName?>prjCandle/view/login.php'>로그인</a>
		<?php
		} else {
		?>
		<!-- 로그인 후 -->
		<a href="<?=$domainName?>prjcandle/view/list.php?page=<?= $page ?>">목록보기</a>
		<a href="<?=$domainName?>prjcandle/view/write.php?mode=write">글쓰기</a>
		<?php
		}
		?>

	</table>
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
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$prev_id[0]'>▽이전글</a>&nbsp;&nbsp;";
	}

	// 다음글 보기 버튼
	$sql_select_next = "SELECT brd_id FROM board WHERE brd_id > $id LIMIT 1";
	$result_next = mysqli_query($conn, $sql_select_next);
	$next_id = mysqli_fetch_row($result_next);
	if ($next_id[0]) //다음 글이 있을 경우
	{
		echo "<a href='$domainName"."prjcandle/board/read.php?page=$page&id=$next_id[0]'>△다음글</a>";
	}
	?>
</div>
<?php
include '../footer.php';
?>
</body>
</html>
