<?php
if(!isset($_SESSION)){
     session_start();
} 
include '../config.php';
include '../dbConfig.php';
include '../common.php';

// 한 페이지에 보여질 게시물 수
$page_size = 10;

// 총 게시물 수($total_row)
$sql_select_count = "SELECT COUNT(*) FROM board";
$result_count = mysqli_query ( $conn, $sql_select_count );
$temp = mysqli_fetch_row ( $result_count );
// mysqli_fetch_row 함수는 result set에서 레코드를 1개씩 리턴해준다(일반 배열 형태로 접근)
$total_row = $temp[0];

// 첫 번째 페이지의 번호
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}
// 몇 번째 글부터 가져올 지 정할 변수
$page_no = ($page - 1) * $page_size;

$sql_select_list = "SELECT * FROM board ORDER BY brd_id DESC LIMIT " . $page_no . ", " . $page_size;

$result = mysqli_query ( $conn, $sql_select_list );

// echo "총 게시물 수 = " . $total_row . "<br>";
// echo "총 페이지 수 = " . $total_page . "<br>";
// echo "총 블록 수 = " . $total_block . "<br>";
?>
<div class="box">
<body>
	<!-- 게시물 리스트 -->
	<table>
		<tr>
			<td>번호</td>
			<td>글쓴이</td>
			<td>제목</td>
			<td>등록일</td>
			<td>추천</td>
			<td>조회</td>
		</tr>
		<?php
		while ( $row = mysqli_fetch_assoc ( $result ) ) {
		?>
		<tr>
			<td><?= $row['brd_id']?></td>
			<td><?= $row['brd_writer']?></td>
			<td><a href="../board/read.php?page=<?= $page ?>&id=<?= $row['brd_id']?>"><?= $row['brd_title']?></a></td>
			<td><?= $row['brd_created_datetime']?></td>
			<td><?= $row['brd_like']?></td>
			<td><?= $row['brd_check']?></td>
		</tr>
		<?php
		}

		mysqli_close($conn);
		?>
	</table>
	<!-- 페이지 리스트 -->
	<table>
		<tr>
			<td>
			<?php
			include '../board/paging.php';
			?>
			</td>
		</tr>
	</table>
	<?php
	if (! isset ( $_SESSION ['login_user'] )) {
	?>
	<!-- 로그인 전 -->
		<a href="<?=$domainName?>prjCandle/view/login.php">로그인</a>
	<?php
	} else {
	?>
	<!-- 로그인 후 -->
		<a href="<?=$domainName?>prjcandle/view/write.php?mode=write">글쓰기</a>
	    <a href="<?=$domainName?>prjcandle/member/logout.php">로그아웃</a>
	<?php
	}
	?>
</div>
<?php
include '../footer.php';
?>
</body>
</html>
