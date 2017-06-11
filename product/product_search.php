<?php
if(!isset($_SESSION)){
     session_start();
}
$findtext= $_POST['findtext'];
include '../config.php';
include '../common.php';
include '../dbConfig.php';
$query = "SELECT * from product where name like '%$findtext%' order by name";
?>

<body>
		<div class="box" style="padding-left: 600px;">
	<tr>
		<td width="730" align="center" valign="top" bgcolor="#FFFFFF">


			<table width="686" border="0" cellpadding=0 cellspacing=0 class="cmfont">
				<tr bgcolor="8B9CBF"><td height="3" colspan="5"></td></tr>
				<tr height="29" bgcolor="EEEEEE">
					<td width="80"  align="center">그림</td>
					<td align="center">상품명</td>
					<td width="150" align="right">가격</td>
					<td width="20"></td>
				</tr>
				<tr bgcolor="8B9CBF"><td height="1" colspan="5"  bgcolor="AAAAAA"></td></tr>

				<tr height="70">
					<td width="80" align="center" valign="middle">
						<a href="product_detail.php?no=1"><img src="../img/candle1.jpg" width="60" height="60" border="0"></a>
					</td>
					<td align="left" valign="middle">
						<a href="product_detail.php?no=1"><font color="#4186C7"><b>제품명1</b></font></a><br>
						<img src="../img/i_hit.gif" align="absmiddle" vspace="1"> <img src="../img/i_new.gif" align="absmiddle" vspace="1">
					</td>
					<td width="150" align="right" valign="middle">72,000 원</td>
					<td width="20"></td>
				</tr>
				<tr><td align="center" valign="middle" colspan="5" height="1" background="../img/ln1.gif"></td></tr>

				<tr height="70">
					<td width="80" align="center" valign="middle">
						<a href="product_detail.php?no=2"><img src="../img/candle2.jpg" width="60" height="60" border="0"></a>
					</td>
					<td align="left" valign="middle">
						<a href="product_detail.php?no=2"><font color="#4186C7"><b>제품명2</b></font></a><br>
						<img src="../img/i_new.gif" align="absmiddle" vspace="1">
					</td>
					<td width="150" align="right" valign="middle">99,000 원</td>
					<td width="20"></td>
				</tr>
				<tr><td align="center" valign="middle" colspan="5" height="1" background="../img/ln1.gif"></td></tr>

				<tr height="70">
					<td width="80" align="center" valign="middle">
						<a href="product_detail.php?no=3"><img src="../img/candle3.jpg" width="60" height="60" border="0"></a>
					</td>
					<td align="left" valign="middle">
						<a href="product_detail.php?no=3"><font color="#4186C7"><b>제품명3</b></font></a><br>
						<img src="../img/i_sale.gif" align="absmiddle" vspace="1"> <font color="red">20%</font>
					</td>
					<td width="150" align="right" valign="middle"><strike>89,000 원</strike><br>62,400 원</td>
					<td width="20"></td>
				</tr>

				<tr bgcolor="8B9CBF"><td height="3" colspan="5"></td></tr>
			</table>
		</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="690">
	<tr>
		<td height="30" class="cmfont" align="center">
			<img src="../img/i_prev.gif" align="absmiddle" border="0">
			<font color="#FC0504"><b>1</b></font>&nbsp;
			<a href="product_search.php?page=2"><font color="#7C7A77">[2]</font></a>&nbsp;
			<a href="product_search.php?page=3"><font color="#7C7A77">[3]</font></a>&nbsp;
			<img src="../img/i_next.gif" align="absmiddle" border="0">
		</td>
	</tr>
</table>

</td>
</tr>
</div>

<?php
include '../footer.php';
?>
</body>
</html>
