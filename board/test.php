<?php

include '../member/dbConfig.php';

// 한 페이지에 보여질 게시물 수
$page_size = 10;

// 블록 당 페이지 수
$page_list_size = 10;

// 총 게시물 수($total_row)
$sql_select_count = "SELECT COUNT(*) FROM board";
$result_count = mysqli_query ( $conn, $sql_select_count );
$result_row = mysqli_fetch_row ( $result_count );
# mysqli_fetch_row 함수는 result set에서 레코드를 1개씩 리턴해준다(일반 배열 형태로 접근)
$total_row = $result_row [0];

// 페이지의 첫 번째 글 번호
if (!isset($_GET['no']) || $_GET['no'] < 0) {
	$start_no = 0;
} else {
	$start_no = $_GET['no'];
}

$sql_select_list = "SELECT * FROM board ORDER BY brd_id DESC LIMIT " . $start_no . ", " . $page_size;
$result = mysqli_query ( $conn, $sql_select_list );

// 총 페이지 수($total_page)
// 총 게시물 수 / 한 페이지에 보여질 게시물 수($total_row / $page_size)
/* if ($total_row <= 0)
 $total_row = 0; */
$total_page = ceil ( $total_row / $page_size );
# ceil 은 올림 함수

// 총 블록 수($total_block)
// 총 페이지 수 / 블록 당 페이지 수($total_page / $page_list_size)
$total_block = ceil( $total_page / $page_list_size );

// 현재 페이지($current_page)
// $start_no 은 0부터 시작하기 때문에 +1
$current_page = ceil ( ($start_no + 1) / $page_size );

// 페이지 리스트의 처음 페이지($start_page)
$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
# floor 는 소수점 이하 버림 함수

// 페이지 리스트의 마지막 페이지($end_page)
$end_page = $start_page + $page_list_size - 1;

echo "총 게시물 수 = " . $total_row . "<br>";
echo "총 페이지 수 = " . $total_page . "<br>";
echo "총 블록 수 = " . $total_block . "<br>";
echo "현재 페이지 = " . $current_page;



function paging ($total_row, $page_size, $page_list_size) {
	// 페이징 시작
	// 페이지 get 변수가 있으면 받아오고 없다면 1페이지를 보여주기 위해
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	
	// 전체 게시글 수
	$total_list = $total_row;
	
	// 한 페이지에 보여질 게시물 수
	$page_num = $page_size;
	
	// 블록 당 페이지 수
	$block_num = $page_list_size;
	
	// 전체 페이지 수
	$total_page = ceil ( $total_list / $page_num );
	# ceil 은 올림 함수
	
	if ($page < 1 || $page > $total_page) {
		echo "<script>alert('존재하지 않는 페이지입니다.'); history.back(-1); </script>";
		exit();
	}
	
	// 현재 블록
	$current_block = ceil($page / $block_num);
	
	// 전체 블록 수
	// 전체 페이지 수 / 블록 당 페이지 수
	$total_block = ceil( $total_page / $block_num );
	
	// 페이지 리스트(현재 블록)의 처음 페이지와 마지막 페이지
	$first_page = ($current_block * $block_num ) - ( $block_num - 1);
	if ($current_block == $total_block) {
		$last_page = $total_block;
	} else {
		$last_page = $current_block * $block_num;
	}
	
	// 이전 블록
	$prev_block = (( $current_block - 1 ) * $block_num );
	// 다음 블록
	$next_block = (( $current_block + 1 ) * $block_num ) - ( $block_num - 1 );
	
	// 페이징을 저장할 변수
	$paging = "";
	
	// 첫 페이지가 아니라면 처음 버튼을 생성
	if($page != 1) {
		$paging .= "<a href='list.php?page=1'>처음</a>";
	}
	// 처음 블록이 아니라면 이전 버튼을 생성
	if($current_block != 1) {
		$paging .= "<a href='.list.php?page=" . $prev_block. "'>이전</a>";
	}
	
	// 현재 페이지에는 링크를 표시하지 않기 위해
	for($i = $first_page; $i <= $last_page; $i++) {
		if($i == $page) {
			$paging .= $i;
		} else {
			$paging .= "<a href='list.php?page=" . $i . "'>" . $i . "</a>";
		}
	}
	
	// 마지막 블록이 아니라면 다음 버튼을 생성
	if($current_block != $total_block) {
		$paging .= "<a href='list.php?page=" . $next_block . "'>다음</a>";
	}
	
	// 마지막 페이지가 아니라면 끝 버튼을 생성
	if($page != $total_page) {
		$paging .= "<a href='list.php?page=" . $allPage . "'>끝</a>";
	}
	
}
?>