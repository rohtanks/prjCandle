<?php
include '../dbConfig.php';

$query = "SELECT * from product";
$result = mysqli_query ( $conn, $query );
$total_count = mysqli_num_rows ( $result );

$b_pageNum_list = 10; // 블럭에 나타낼 페이지 번호 갯수
$block = ceil ( $pageNum / $b_pageNum_list ); // 현재 리스트의 블럭 구하기
$b_start_page = (($block - 1) * $b_pageNum_list) + 1; // 현재 블럭에서 시작페이지 번호
$b_end_page = $b_start_page + $b_pageNum_list - 1; // 현재 블럭에서 마지막 페이지 번호
$total_page = ceil ( $total_count / $list ); // 총 페이지 수

if ($b_end_page > $total_page)
	$b_end_page = $total_page;

if ($pageNum <= 1) {
?>
<font size=2 align="center" color=red>처음</font>
<?php
} else {
?>
<font size=2 align="center"><a
	href="../view/product.php?page=&list=<?=$list?>">처음</a></font>
<?php
}

if ($block <= 1) {
?>
<font align="center"> </font>
<?php
} else {
?>
<a href="../view/product.php?page=<?=$b_start_page-1?>&list=<?=$list?>"><img
	src="../img/i_prev.gif" align="center" border="0"></a>
<?php
}

for($j = $b_start_page; $j <= $b_end_page; $j ++) {
	if ($pageNum == $j) {
?>
<font size=2 align="center" color=red><?=$j?></font>
<?php
} else {
?>
<font size=2 align="center"><a
	href="../view/product.php?page=<?=$j?>&list=<?=$list?>"><?=$j?></a></font>
<?php
	}
}

$total_block = ceil ( $total_page / $b_pageNum_list );

if ($block >= $total_block) {
?>
<font align="center"> </font>
<?php
} else {
?>
<a href="../view/product.php?page=<?=$b_end_page+1?>&list=<?=$list?>"><img
	src="../img/i_next.gif" align="center" border="0"></a>
<?php
}

if ($pageNum >= $total_page) {
?>
<font size=2 align="center" color=red>마지막</font>
<?php
} else {
?>
<font size=2 align="center"><a
	href="../view/product.php?page=<?=$total_page?>&list=<?=$list?>">마지막</a></font>
<?php
}
mysqli_close ( $conn );
?>
