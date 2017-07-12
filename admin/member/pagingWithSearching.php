<?php
// Common 클래스에 paging 메서드 구현으로 사용 안함
// 총 페이지 수($totalPage)
// 총 게시물 수 / 한 페이지에 보여질 게시물 수($totalRow / $pageSize)
$totalPage = ceil ( $totalRow / $pageSize );
// ceil 함수는 올림

// 현재 블록
$currentBlock = ceil ( $page / $pageListSize );

// 총 블록 수($totalBlock)
// 총 페이지 수 / 블록 당 페이지 수($totalPage / $pageListSize)
$totalBlock = ceil ( $totalPage / $pageListSize );

// 현재 블록의 처음 페이지($firstPage)
$firstPage = ($currentBlock * $pageListSize) - ($pageListSize - 1);

if ($currentBlock == $totalBlock) {
	// 현재 블록이 마지막 블록이면 총 페이지 수가 마지막 페이지가 된다
	$lastPage = $totalPage;
} else {
	$lastPage = $currentBlock * $pageListSize;
}

// 이전 리스트($prevList)
$prevList = ($currentBlock - 1) * $pageListSize;

// 다음 리스트($nextList)
$nextList = (($currentBlock + 1) * $pageListSize) - ($pageListSize - 1);

// 실제 리스트 페이지
// 첫 페이지가 아니라면 처음 버튼을 생성
if ($page != 1) {
	echo "<a href='" . htmlentities ( $_SERVER ['PHP_SELF'] ) . "?page=1" . $subString . "'> 처음 </a>";
}
// $_SERVER['PHP_SELF'] 현재 페이지의 주소에서 도메인과 넘겨지는 파라미터 값을 제외한 정보
// 혹은 현재 페이지의 페이지 이름을 리턴해주는 역할을 한다고 한다
// 블록의 첫 페이지가 블록 당 페이지 수보다 크면 이전 버튼을 생성
if ($firstPage >= $pageListSize) {
	echo "<a href='" . htmlentities ( $_SERVER ['PHP_SELF'] ) . "?page=" . $prevList . $subString . "'> 이전 </a>";
}

for($i = $firstPage; $i <= $lastPage; $i ++) {
	if ($i != $page) { // 현재 페이지에는 링크를 표시하지 않기 위해
		echo "<a href='" . htmlentities ( $_SERVER ['PHP_SELF'] ) . "?page=" . $i . $subString . "'>";
	}
	echo " $i ";
	
	if ($i != $page) {
		echo "</a>";
	}
}

// 총 페이지가 마지막 블록보다 클 때는 다음 버튼을 생성
if ($totalPage > $lastPage) {
	echo "<a href='" . htmlentities ( $_SERVER ['PHP_SELF'] ) . "?page=" . $nextList . $subString . "'> 다음 </a>";
}
// 마지막 페이지가 아니라면 끝 버튼을 생성
if ($page != $totalPage) {
	echo "<a href='" . htmlentities ( $_SERVER ['PHP_SELF'] ) . "?page=" . $totalPage . $subString . "'> 끝 </a>";
}

// // 글의 no를 위한 작업 일단 보류
// // 페이지에 정렬되는 게시글의 순차적인 번호를 구하기 위한 쿼리
// $sql_select_rnum = "SELECT @rownum:=@rownum+1 rnum FROM board, (select @rownum:=0) tmp ORDER BY rnum";

?>