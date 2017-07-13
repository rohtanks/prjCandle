<?php
// /// 회원 정보 조회 페이지 /////
include '../common.php';
include '../../dbConfig.php';
session_start ();
// 관리자 로그인 체크
if (isset ( $_SESSION ['super_user'] )) {
	$superUser = $_SESSION ['super_user'];
}
if (isset ( $_SESSION ['super_level'] )) {
	$level = $_SESSION ['super_level'];
}
if (! $superUser && ! $level) {
	header ( 'Location: '.$domainName.'prjCandle/admin/view/login.php' );
} elseif ($level > 2) {
	header ( 'Location: '.$domainName.'prjCandle/admin/view/admin.php' );
}
include "../../lib/class.common.php";
include "../../lib/class.admin.php";
$common = new Common (); // 일반 함수들을 사용하기 위한 객체(paging 등 함수로 만들어 놓은 클래스)
$admin = new Admin (); // 관리자 페이지에서 사용할 함수들 모아놓은 객체
$admin->get_object ( $common );

// /// 회원 정보 검색 시작 /////
if (isset ( $_POST ['search_type'] )) {
	$search_type = $_POST ['search_type'];
}
if (isset ( $_POST ['search_text'] )) {
	$search_text = $_POST ['search_text'];
}
if (isset ( $_POST ['mem_startDate'] )) { // isset을 사용하면 날짜를 선택하지 않아도 true
	$mem_startDate = $_POST ['mem_startDate'];
}
if (isset ( $_POST ['mem_endDate'] )) {
	$mem_endDate = $_POST ['mem_endDate'];
}

if (!empty ( $_POST ['pageSize'] )) { // 기본 선택을 해도 post변수는 존재하기 때문에 empty로 검사
	$pageSize = ( int ) $_POST ['pageSize'];
} else {
	// 한 페이지에 보여질 게시물 수
	$pageSize = 10;
}

if (isset ( $_POST ['order'] )) {
	$arr = explode ( ',', $_POST ['order'] );
	$order = $arr [0] . " " . $arr [1];
} else {
	$order = "mem_id DESC";
}

// echo var_dump($search_type).var_dump($search_text).var_dump($mem_startDate).var_dump($mem_endDate).var_dump($pageSize);

// 총 회원 수($total_row)
$sql_total_count = "SELECT COUNT(*) FROM member"; // 총 회원 수 구하기 위한 쿼리
$select_count = mysqli_query ( $conn, $sql_total_count );
$temp = mysqli_fetch_row ( $select_count );
// mysqli_fetch_row 함수는 result set에서 레코드를 1개씩 리턴해준다(일반 배열 형태로 접근)
$total_row = $temp [0]; // 고정적으로 보여줄 총 회원 수
                       
// 첫 번째 페이지의 번호
if (isset ( $_POST ['page'] )) {
	$page = $_POST ['page'];
} else {
	$page = 1;
}
// $pageNO 몇 번째 글부터 가져올 지 정할 변수 / 만약 8페이지를 보다가 $pageSize를 100으로 바꾸면 700번 글부터 가져와버림
$pageNo = ($page - 1) * $pageSize;

// 조건을 나눠보자 //
// 기본 search_type과 search_text로 이름, 아이디 등으로 검색
// search_type, search_text만 필요
// where $search_type like '%$search_text%'
// 예외로 search_type이 선택으로 찍혀들어올 때는 전체 회원이 검색되도록
// 가입일만으로 검색
// mem_startDate, mem_endDate만 필요
// where $mem_created_datetime between $mem_startDate and $mem_endDate

$searchSql = "";

if (isset ( $_POST ['search_type'] ) || isset ( $_POST ['search_text'] ) || isset ( $_POST ['mem_startDate'] ) || isset ( $_POST ['mem_endDate'] )) {
	if ($search_type && $search_text) {
		$searchSql = "WHERE " . $search_type . " LIKE '%" . $search_text . "%'";
	}
	if ($mem_startDate && $mem_endDate) {
		$searchSql = "WHERE mem_created_datetime BETWEEN '" . $mem_startDate . "' AND '" . $mem_endDate . "'";
	}
	if ($search_type && $search_text && ! empty ( $mem_startDate ) && ! empty ( $mem_endDate )) {
		$searchSql = "WHERE " . $search_type . " LIKE '%" . $search_text . "%' AND mem_created_datetime BETWEEN '" . $mem_startDate . "' AND '" . $mem_endDate . "'";
	}
	if (empty ( $search_type )) {
		$searchSql = "WHERE mem_id = null";
	}
	$sql_search_count = "SELECT COUNT(*) FROM member " . $searchSql; // 검색된 회원 수 구하기 위한 쿼리
	$search_count = mysqli_query ( $conn, $sql_search_count );
	$tmp = mysqli_fetch_row ( $search_count );
	$search_totalRow = $tmp [0]; // 검색된 전체 회원 수
	                            
	// 검색 결과에서 정렬이나 리스트 수를 바꿀 때 고정되는 현상 해결을 위해
	// 검색된 전체 회원 수보다 시작 글 번호가 더 클 때 대비
	if ($search_totalRow < $pageNo) {
		$pageNo = 0; // 시작 글 번호를 0으로 바꾸고
		$page = 1; // 페이지도 1로 바꾼다
	}
	// TODO 검색 결과에서 정렬 순서를 바꾸고 재 검색 시 기준이 고정되는 문제 해결
	
	$sql_select_member = "SELECT * FROM member " . $searchSql . " ORDER BY " . $order . " LIMIT " . $pageNo . ", " . $pageSize;
// 	echo $sql_select_member;
	$result = mysqli_query ( $conn, $sql_select_member );
}
?>
	<div id="page-wrapper">
		<!-- 회원 정보 검색창 -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">회원 정보 조회</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form name="search_form" id="sform"
							action="<?=htmlentities($_SERVER['PHP_SELF'])?>" method="post">
							<input type="hidden" name="pageSize" value="<?=$pageSize?>" />
							<!-- 리스트 갯수 선택 값이 여기로 들어온다 -->
							<input type="hidden" name="page" id="page" value="<?=$page?>" /> <input
								type="hidden" name="order" value="<?=$order?>" />
									<?php
									$common->addHiddenField ( 'search_type', $_POST );
									?>		
									<table class="table table-bordered table-hover">
								<tbody>
									<tr>
										<th>개인정보</th>
										<td colspan="3">
													<?=	$admin -> selectMemType($search_type) ?>
													<input name="search_text" class="searchText"
											style="width: 130px;" value="<?=$search_text?>"> <!-- 이렇게 하면 검색 결과가 유지된다 -->
										</td>
									</tr>
									<tr>
										<th>가입일/기념일</th>
										<td colspan="3">
											<select name="date_type" class="dateType">
												<option selected="selected" value="">- 선택 -</option>
												<option value="1">가입일</option>
											</select>
											<div style="float: left;">
												<span class="gLabel" style="margin-left: 5px; float: left;">
													<div id="reg_form" class="invisible">
														<input name="mem_startDate" class="datepicker"
															id="regist_start_date" style="width: 75px;" type="text"> ~
														<input name="mem_endDate" class="datepicker"
															id="regist_end_date" style="width: 75px;" type="text">
													</div>
												</span>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<div>
								<span>
									<button type="submit">검색</button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- 회원 정보 검색창 -->
		<!-- 검색 결과 -->
	
		<!-- 일반보기 -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						회원 목록
					</div>
					<!-- /.panel-heading -->
					<div class="gLeft">
						<p class="total">
							[총 회원수 <strong><?=$total_row?></strong>명] 검색결과 <strong class="search_total"><?=isset($search_totalRow)?$search_totalRow:0?></strong>건
						</p>
					</div>
					<form name="page_sizeForm"
						action="<?=htmlentities($_SERVER['PHP_SELF'])?>">
						<!-- TODO 검색 결과가 있을 때 제대로 작동 안함 이 문제 고쳐야 한다 -> 해결-->
						<select name="pageSize" class="fSelect" id="rows"
							onchange="submitPageSize(this)">
							<option value="">리스트 갯수</option>
							<option value="10"
								<?= ($pageSize== 10) ? "selected='selected'" : null ?>>10개씩보기</option>
							<option value="20"
								<?= ($pageSize== 20) ? "selected='selected'" : null ?>>20개씩보기</option>
							<option value="30"
								<?= ($pageSize== 30) ? "selected='selected'" : null ?>>30개씩보기</option>
							<option value="50"
								<?= ($pageSize== 50) ? "selected='selected'" : null ?>>50개씩보기</option>
							<option value="100"
								<?= ($pageSize== 100) ? "selected='selected'" : null ?>>100개씩보기</option>
							<option value="200"
								<?= ($pageSize== 200) ? "selected='selected'" : null ?>>200개씩보기</option>
							<option value="500"
								<?= ($pageSize== 500) ? "selected='selected'" : null ?>>500개씩보기</option>
							<option value="1000"
								<?= ($pageSize== 1000) ? "selected='selected'" : null ?>>1,000개씩보기</option>
						</select>
					</form>
					<div class="panel-body">
						<form name="list_form" id="lform"
							action="<?=$domainName?>prjCandle/admin/member/member_v.php" method="post">
							<input type="hidden" name="page" value="<?=$page?>" />
							<?php 
							$common->addHiddenField('mem_id', $_POST);
							?>
							<table class="table table-striped table-bordered table-hover"
								id="dataTables-example">
								<thead>
									<tr>
										<th><strong class="array "> <span onclick="">회원번호</span>
												<button type="button" id="btn_order_memId"
													class="fa fa-toggle-down"
													onclick="submitOrderItem('mem_id', 'asc')"></button>
										</strong></th>
										<th><strong class="array "> <span>가입일</span>
												<button type="button" id="btn_order_memCreatedDate"
													class="fa fa-toggle-down"
													onclick="submitOrderItem('mem_created_datetime', 'asc')"></button>
										</strong></th>
										<th><strong class="array "> <span
												onclick="submitSearch('member_name', 'DESC')">이름</span>
												<button type="button" id="btn_order_memName"
													class="fa fa-toggle-down"
													onclick="submitOrderItem('mem_name', 'asc')"></button>
										</strong></th>
										<th><strong class="array "> <span
												onclick="submitSearch('member_id', '')">아이디</span>
												<button type="button" id="btn_order_memNickname"
													class="fa fa-toggle-down"
													onclick="submitOrderItem('mem_nickname', 'asc')"></button>
										</strong></th>
										<th>휴대전화</th>
										<th><strong class="array "> <span
												onclick="submitSearch('region', '')">주소</span> <!-- TODO 주소는 정렬 대신 지역별 검색이 가능하도록 -->
										</strong></th>
										<th>메일/SMS/메모</th>
									</tr>
								</thead>
								<tbody id="areaResult" class="">
							        <?php
									if (isset ( $result )) {
										while ( $row = mysqli_fetch_assoc ( $result ) ) {
									?>
							        	<tr>
										<td><a href="javascript:goMemberView(<?=$row['mem_id']?>);"><?=$row['mem_id']?></a></td>
										<td><?=$row['mem_created_datetime']?></td>
										<td><a href="javascript:goMemberView(<?=$row['mem_id']?>);"><?=$row['mem_name']?></a></td>
										<td><a href="javascript:goMemberView(<?=$row['mem_id']?>);"><?=$row['mem_nickname']?></a></td>
										<td><?=$row['mem_phoneNum']?></td>
										<td><?=$row['mem_addr']?></td>
										<td><?=$row['mem_email']?></td>
									</tr>
									<?php
										}
									}
									mysqli_close ( $conn );
									?>	
							    </tbody>
							</table>
						</form>
						
						<!-- 페이징 -->
						<div>
							<?php
							$params = array (
									'pageSize' => $pageSize,
									'pageListSize' => $pageListSize,
									'page' => ( int ) $page,
									'totalRow' => $search_totalRow,
									'pageType' => 'bootstrapPost' 
							);
							if ($search_totalRow > 0) {
								echo $common->paging ( $params );
							} else {
							?>
						        <p class="empty" style="display: block;">검색된 회원 내역이 없습니다.</p>
					        <?php
							}
							?>
					        </div>
						<!-- 페이징 -->
					</div>
				</div>
			</div>
		</div>
	
	</div>
	<!-- /#page-wrapper -->
<!-- wrapper div까지 닫자! -->
</div>
<!-- /#wrapper -->

<script type="text/javascript">
	var searchTotal = <?=isset($search_totalRow)?$search_totalRow:0?>;
	var sf = document.search_form; // name으로 찾나봐
	var lf = document.list_form;
	function submitPageSize(v){
		sf.pageSize.value = v.value;
		if (searchTotal > 0) {
			sf.submit();
		}
	}
	function submitOrderItem(i, o){
		if (searchTotal > 0) { // 검색 값이 없을 때 전송하면 정렬 순서가 미리 고정됨
			sf.order.value = i +","+ o;
			sf.submit();
		}	
	}
	function goMemberView(v) {
		console.log(v);
		lf.mem_id.value = v;
		lf.submit();
	}
	function gotoPage(page){
		$("#page").val(page);
		console.log($("#page").val(page));
		$("#sform").submit();
	}
	// jQuery
	$(function () {
	// 가입일/기념일 선택 토글 시작
		$('.dateType').on('change', function () { // TODO 검색 후 입력 폼이 다시 사라지지 않도록 처리해야함
			if ($(this).val() != '') {
				$('#reg_form').toggleClass('visible');
				$('#reg_form').toggleClass('invisible');
			} else {
				$('#reg_form').removeClass('visible');
				$('#reg_form').addClass('invisible');
			}
		});
		// 가입일/기념일 선택 토글 끝
		// 날짜선택기 세팅 시작
		$('.datepicker').each(function () { // 날짜 선택(개별 선택 이벤트는 onSelect: function() {})
			$(this).datepicker({
				showOn: 'both',
				buttonImage: '/prjCandle/img/3_calendar_icon.png',
				nextText: '다음 달',
				prevText: '이전 달',
				currentText: '오늘',
				buttonImageOnly: true,
				showMonthAfterYear: true,
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd',
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']
			})
		});
		// 날짜선택기 세팅 끝
		
	});
</script>
<?php
include '../footer.php';
?>
</body>
</html>