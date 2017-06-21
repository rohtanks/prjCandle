<?php
error_reporting(0);
$sel1= $_POST['sel1'];
$text1= $_POST['text1'];
include '../common.php';
include '../dbConfig.php';

if(!$sel1) $sel1=1;
if(!$text1) $text1="";

if(text1)
{
	if($sel1 == 1) $query = "SELECT * from product where productname like '%$text1%' order by productname";
	if($sel1 == 2) $query = "SELECT * from product where productno like '%$text1%' order by productno";
}

$result= mysqli_query ( $conn, $query );
$total_rows = mysqli_num_rows($result);
?>
<body style="margin:0">
<center>
<br>
<script> document.write(menu());</script>

<table width="800" border="0" cellspacing="0" cellpadding="0">
	<form name="form1" method="post" action="product.php">
	<tr height="40">
		<td align="left"  width="150" valign="bottom">&nbsp 제품수 : <font color="#FF0000"><?= $total_rows?></font></td>
		<td align="right" width="550" valign="bottom">
			<select name="sel1">
				<option value="1" selected>제품이름</option>
				<option value="2" >제품번호</option>
			</select>
			<input type="text" name="text1" size="10" value="">&nbsp
		</td>
		<td align="left" width="120" valign="bottom">
			<input type="button" value="검색" onclick="javascript:form1.submit();"> &nbsp;&nbsp
			<input type="button" value="입력" onclick="javascript:go_new();">
		</td>
	</tr>
	<tr><td height="5"></td></tr>
	</form>
</table>

<table width="800" border="1" cellpadding="2" style="border-collapse:collapse">
	<tr bgcolor="#CCCCCC" height="23">
		<td width="100" align="center">상품번호</td>
		<td width="280" align="center">상품이름</td>
		<td width="70"  align="center">상품가격</td>
		<td width="80"  align="center">수정/삭제</td>
	</tr>
	<?php
	while ($row = mysqli_fetch_assoc ( $result ) ) {
		?>
	<tr bgcolor="#F2F2F2" height="23">
		<td width="100">&nbsp <?=$row['productno']?></td>
		<td width="100">&nbsp <?=$row['productname']?></td>
		<td width="280">&nbsp <?=$row['productprice']?></td>
		<td width="80"  align="center">
			<a href="product_edit.php?no=<?=$row['productno']?>&sel1=<?=$row['productname']?>&text1=<?=$row['productprice']?>&img1=<?=$row['productimage1']?>&img2=<?=$row['productimage2']?>&img3=<?=$row['productimage3']?>">수정</a>/
			<a href="product_delete.php?no=<?=$row['productno']?>" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>
		</td>
		<?php
		}
		mysqli_close($conn);
		?>
	</tr>
</table>

<table width="800" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="30" class="cmfont" align="center">
			<img src="../img/i_prev.gif" align="absmiddle" border="0">
			<font color="#FC0504"><b>1</b></font>&nbsp;
			<a href="product.php?page=2&sel1=&text1="><font color="#7C7A77">[2]</font></a>&nbsp;
			<a href="product.php?page=3&sel1=&text1="><font color="#7C7A77">[3]</font></a>&nbsp;
			<img src="../img/i_next.gif" align="absmiddle" border="0">
		</td>
	</tr>
</table>

</center>

</body>
</html>
