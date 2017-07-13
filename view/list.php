<?php
if(!isset($_SESSION)){
	session_start();
}
include '../dbConfig.php';
include '../common.php';

// 검색 시작
if (isset($_GET['search_type'])) {
	$search_type = $_GET['search_type']; // 게시판 검색 셀렉트 박스 항목
	$subString .= "&amp;search_type=".$search_type; // 페이지에 붙여넣을 변수, &amp; 는 &(엠퍼샌드)
}
if (isset($_GET['search_text'])) {
	$search_text = $_GET['search_text']; // 게시판 검색어
	$subString .= "&amp;search_text=".$search_text;
}
if (isset($_GET['search_type']) && isset($_GET['search_text'])) {
	if ($search_type === 'title_content') { // 검색 항목이 제목+본문일 경우
		$searchSql = "WHERE brd_title LIKE '%".$search_text."%' OR brd_content LIKE '%".$search_text."%'";
	} elseif ($search_type === 'co_content') { // 검색 항목이 댓글내용일 경우
		$searchSql = "";
	} elseif ($search_type === 'co_writer') { // 검색 항목이 댓글작성자일 경우
		$searchSql = "";
	} else {
		$searchSql = "WHERE ".$search_type." LIKE '%".$search_text."%'";
	}
} else {
	$searchSql = "";
} // TODO 검색 항목에서 댓글내용, 댓글작성자 검색 구현해야함
// 검색 끝

// 한 페이지에 보여질 게시물 수
$page_size = 10;

// 총 게시물 수($total_row)
$sql_select_count = "SELECT COUNT(*) FROM board ".$searchSql;
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

$sql_select_list = "SELECT * FROM board ".$searchSql." ORDER BY brd_id DESC LIMIT " . $page_no . ", " . $page_size;

$result = mysqli_query ( $conn, $sql_select_list );

// 댓글 갯수 조회 후 반영
$sql_update_commentNum = "UPDATE board AS b SET brd_commentNum = (SELECT COUNT(*) FROM comment AS c WHERE c.brd_id = b.brd_id)";
mysqli_query($conn, $sql_update_commentNum);
?>
	<div class="container">
		<div class="row">
            <div class="box">
                <div align="center" class="col-lg-12">
                	<hr>
                    <h2 class="intro-text text-center">
                        <strong>게시판</strong>
                    </h2>
                    <hr>
                	<div class="panel panel-default">
                		<div class="panel-body">
                			<div class="table-responsive table-bordered">
			                	<!-- 게시물 리스트 -->
								<table class="table table-hover">
									<thead>
										<tr>
											<th>번호</th>
											<th>글쓴이</th>
											<th>제목</th>
											<th>등록일</th>
											<th>추천</th>
											<th>조회</th>
										</tr>
									</thead>
									<tbody>
									<?php
									while ( $row = mysqli_fetch_assoc ( $result ) ) {
									?>
										<tr>
											<td><?= $row['brd_id']?></td>
											<td><?= $row['brd_writer']?></td>
											<td><a href="../board/read.php?page=<?= $page ?>&id=<?= $row['brd_id']?><?=$subString?>"><?= $row['brd_title']?>
											<?php if (($row['brd_commentNum']) > 0) {?>
											[<?=$row['brd_commentNum']?>]<?php }?></a></td>
											<td><?= $row['brd_created_datetime']?></td>
											<td><?= $row['brd_like']?></td>
											<td><?= $row['brd_check']?></td>
										</tr>
									<?php
									}
									mysqli_close($conn);
									?>
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive table-bordered -->
							<!-- 페이지 리스트 -->
							<table class="pagination">
								<tr>
									<td>
									<?php
									if ($total_row < 1) {
										echo "게시물이 없습니다.";
									} else {
										include '../board/pagingWithSearching.php';
									}
									?>
									</td>
								</tr>
							</table>
							<table class="table">
							<?php
							if (! isset ( $_SESSION ['login_user'] )) {
							?>
								<tr>	
								<!-- 로그인 전 -->
									<td>
										<a href="<?=$domainName?>prjCandle/view/login.php">로그인</a>
									</td>
							<?php
							} else {
							?>
								<!-- 로그인 후 -->
									<td>
										<a href="<?=$domainName?>prjcandle/view/write.php?mode=write">글쓰기</a>
									</td>
									<td>
								    	<a href="<?=$domainName?>prjcandle/member/logout.php">로그아웃</a>
								    </td>
								</tr>
							<?php
							}
							?>
							</table>
							<!-- 게시판 검색창 -->
							<div class="col-lg-12">
								<form role="form" action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="get">
									<div class="form-group">
										<select name="search_type" class="form-control">
											<option value="title_content" <?= ($search_type=='title_content') ? "selected='selected'" : null ?>>제목+본문</option> <!-- 페이지 변경시 셀렉트 박스를 유지하기 위해 -->
											<option value="brd_title" <?= ($search_type=='brd_title') ? "selected='selected'" : null ?>>제목</option>
											<option value="brd_writer" <?= ($search_type=='brd_writer') ? "selected='selected'" : null ?>>작성자</option>
											<option value="co_content" <?= ($search_type=='co_content') ? "selected='selected'" : null ?>>댓글내용</option>
											<option value="co_writer" <?= ($search_type=='co_writer') ? "selected='selected'" : null ?>>댓글작성자</option>
										</select>
									</div>
									<div class="form-group input-group">
										<!-- 페이지 변경시 검색창에 검색어를 유지하기 위해 -->
									 	<input type="text" name="search_text" class="form-control" maxlength="40" size="18" value="<?= (isset($search_text)) ? $search_text : null ?>" />
										<span class="input-group-btn">
											<button type="button" class="btn btn-default"><i class="fa fa-search"></i></button> <!-- TODO 검색버튼 기능 구현해야함 -->
										</span>
									</div>
								</form>
							</div>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel panel-default -->
                </div>
                <!-- /.col-lg-12 -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.row -->
	</div>
    <!-- /.container -->
<?php
include '../footer.php';
?>
</body>
</html>