<?php
error_reporting ( 0 );
$sel1 = $_POST ['sel1'];
$text1 = $_POST ['text1'];
include '../common.php';
include '../dbConfig.php';

if (! $sel1)
	$sel1 = 1;
	if (! $text1)
		$text1 = "";
		
		if (text1) {
			if ($sel1 == 1)
				$query = "SELECT * from product where productname like '%$text1%' order by productname";
				if ($sel1 == 2)
					$query = "SELECT * from product where productno like '%$text1%' order by productno";
		}
		
		$result = mysqli_query ( $conn, $query );
		$total_rows = mysqli_num_rows ( $result );
		?>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">상품 정보 조회</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
						<div class="panel-heading">
							<form name="form1" method="post" action="product.php">
								<div align="left">&nbsp 제품수 : <font	color="#FF0000"><?= $total_rows?></font></div>
								<div align="center" >
									<select name="sel1">
										<option value="1" selected>제품이름</option>
										<option value="2">제품번호</option>
									</select>
									<input type="text" name="text1" value="">
									<input type="button" value="검색" onclick="javascript:form1.submit();">
								</div>
								<div align="right">
									<input type="button" value="입력" onclick="javascript:go_new();">
								</div>	
							</form>
						</div>	
						<!-- /.panel-heading -->
						<div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr bgcolor="#CCCCCC" height="23">
									<th>상품번호</th>
									<th>상품이름</th>
									<th>상품가격</th>
									<th>수정/삭제</th>
								</tr>
							</thead>	
							<tbody>
							<?php
							while ( $row = mysqli_fetch_assoc ( $result ) ) {
							?>
								<tr bgcolor="#F2F2F2" height="23">
									<td width="100">&nbsp <?=$row['productno']?></td>
									<td width="100">&nbsp <?=$row['productname']?></td>
									<td width="280">&nbsp <?=$row['productprice']?></td>
									<td width="80" align="center"><a
										href="<?=$domainName?>prjCandle/admin/product/product_edit.php?no=<?=$row['productno']?>&sel1=<?=$row['productname']?>&text1=<?=$row['productprice']?>&img1=<?=$row['productimage1']?>&img2=<?=$row['productimage2']?>&img3=<?=$row['productimage3']?>">수정</a>/
									<a href="<?=$domainName?>prjCandle/admin/product/product_delete.php?no=<?=$row['productno']?>"
									onclick="javascript:return confirm('삭제할까요 ?');">삭제</a></td>
							<?php
							}
							mysqli_close ( $conn );
							?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<?php
include '../footer.php';
?>
</body>
</html>