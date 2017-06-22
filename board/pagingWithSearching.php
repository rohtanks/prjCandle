<?php
// 총 페이지 수($total_page)
// 총 게시물 수 / 한 페이지에 보여질 게시물 수($total_row / $page_size)
$total_page = ceil($total_row / $page_size);
# ceil 함수는 올림

// if ($page < 1 || ($total_page && $page > $total_page)) {
// 	echo "<script>alert('존재하지 않는 페이지입니다.'); history.back();</script>";
// 	exit();
// }

// 블록 당 페이지 수
$page_list_size = 10;

// 현재 블록
$current_block = ceil($page / $page_list_size);

// 총 블록 수($total_block)
// 총 페이지 수 / 블록 당 페이지 수($total_page / $page_list_size)
$total_block = ceil ( $total_page / $page_list_size );

// 현재 블록의 처음 페이지($first_page)
$first_page = ($current_block * $page_list_size) - ($page_list_size - 1);

if ($current_block == $total_block) {
	// 현재 블록이 마지막 블록이면 총 페이지 수가 마지막 페이지가 된다
	$last_page = $total_page;
} else {
	$last_page = $current_block * $page_list_size;
}

// 이전 리스트($prev_list)
$prev_list = ($current_block -1) * $page_list_size;

// 다음 리스트($next_list)
$next_list = (($current_block + 1) * $page_list_size) - ($page_list_size - 1);

// 실제 리스트 페이지
// 첫 페이지가 아니라면 처음 버튼을 생성
if ($page != 1) {
	echo "<a href='".$_SERVER['PHP_SELF']."?page=1".$subString."'> 처음 </a>";
}
# $_SERVER['PHP_SELF'] 현재 페이지의 주소에서 도메인과 넘겨지는 파라미터 값을 제외한 정보
# 혹은 현재 페이지의 페이지 이름을 리턴해주는 역할을 한다고 한다
// 블록의 첫 페이지가 블록 당 페이지 수보다 크면 이전 버튼을 생성
if ($first_page >= $page_list_size) {
	echo "<a href='list.php?page=" . $prev_list .$subString."'> 이전 </a>";
}

for($i = $first_page; $i <= $last_page; $i ++) {
	if ($i != $page) { // 현재 페이지에는 링크를 표시하지 않기 위해
		echo "<a href='list.php?page=" . $i .$subString. "'>";
	}
	echo " $i ";

	if ($i != $page) {
		echo "</a>";
	}
}

// 총 페이지가 마지막 블록보다 클 때는 다음 버튼을 생성
if($total_page > $last_page) {
	echo "<a href='list.php?page=" . $next_list .$subString. "'> 다음 </a>";
}
// 마지막 페이지가 아니라면 끝 버튼을 생성
if ($page != $total_page) {
	echo "<a href='list.php?page=". $total_page .$subString. "'> 끝 </a?>";
}


// // 글의 no를 위한 작업 일단 보류
// // 페이지에 정렬되는 게시글의 순차적인 번호를 구하기 위한 쿼리
// $sql_select_rnum = "SELECT @rownum:=@rownum+1 rnum FROM board, (select @rownum:=0) tmp ORDER BY rnum";

?>