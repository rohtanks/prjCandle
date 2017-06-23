<?php
if(!isset($_SESSION)){
     session_start();
}
include '../config.php';
include '../common.php';
include '../dbConfig.php';

$no= $_POST['no'];
$opts1= $_POST['opts1'];
$opts2= $_POST['opts2'];
$num= $_POST['num'];

$query = "SELECT * from product where productno like '%$no%'";
$result = mysqli_query ( $conn, $query );
$row = mysqli_fetch_array( $result );
?>
			<script language = "javascript">

			function cart_edit(kind,pos) {
				if (kind=="deleteall")
				{
					location.href = "cart_edit.html?kind=deleteall";
				}
				else if (kind=="delete")	{
					location.href = "cart_edit.html?kind=delete&pos="+pos;
				}
				else if (kind=="insert")	{
					var num=eval("form2.num"+pos).value;
					location.href = "cart_edit.html?kind=insert&pos="+pos+"&num="+num;
				}
				else if (kind=="update")	{
					var num=eval("form2.num"+pos).value;
					location.href = "cart_edit.html?kind=update&pos="+pos+"&num="+num;
				}
			}

			</script>
    <div class="box" style="padding-left: 600px;">
			<!-- form2 시작  -->
			<table border="0" cellpadding="0" cellspacing="0" width="747">
				<tr><td height="13"></td></tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="746">
				<tr>
					<td height="30" align="left"><img src="../img/cart_title.gif" width="746" height="30" border="0"></td>
				</tr>
			</table>
			<table border="0" cellpadding="0" cellspacing="0" width="747">
				<tr><td height="13"></td></tr>
			</table>

			<table border="0" cellpadding="0" cellspacing="0" width="710" class="cmfont">
				<tr>
					<td><img src="../img/cart_title1.gif" border="0"></td>
				</tr>
			</table>

			<table border="0" cellpadding="0" cellspacing="0" width="710">
				<tr><td height="10"></td></tr>
			</table>

			<table border="0" cellpadding="5" cellspacing="1" width="710" class="cmfont" bgcolor="#CCCCCC">
				<tr bgcolor="F0F0F0" height="23" class="cmfont">
					<td width="420" align="center">상품</td>
					<td width="70"  align="center">수량</td>
					<td width="80"  align="center">가격</td>
					<td width="90"  align="center">합계</td>
					<td width="50"  align="center">삭제</td>
				</tr>

				<form name="form2" method="post">
				<tr>
					<td height="60" align="center" bgcolor="#FFFFFF">
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="60">
									<a href="product_detail.php?no=<?= $row['productno']?>"><img src="<?= $row['productimage1']?>" width="50" height="50" border="0"></a>
								</td>
								<td class="cmfont">
									<a href="product_detail.php?no=<?= $row['productno']?>"><?= $row['productname']?></a><br>
									<font color="#0066CC">[옵션사항]</font> <?= $opts1?>, <?= $opts2?>
								</td>
							</tr>
						</table>
					</td>
					<td align="center" bgcolor="#FFFFFF">
						<input type="text" name="num1" size="3" value="<?= $num?>" class="cmfont1">&nbsp<font color="#464646">개</font>
					</td>
					<td align="center" bgcolor="#FFFFFF"><font color="#464646"><?= $row['productprice'] * $num?></font></td>
					<td align="center" bgcolor="#FFFFFF"><font color="#464646"><?= $row['productprice'] * $num?></font></td>
					<td align="center" bgcolor="#FFFFFF">
						<a href = "javascript:cart_edit('update','1')"><img src="../img/b_edit1.gif" border="0"></a>&nbsp<br>
						<a href = "javascript:cart_edit('delete','1')"><img src="../img/b_delete1.gif" border="0"></a>&nbsp
					</td>
				</tr>

				<tr>
					<td colspan="5" bgcolor="#F0F0F0">
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cmfont">
							<tr>
								<td bgcolor="#F0F0F0"><img src="../img/cart_image1.gif" border="0"></td>
								<td align="right" bgcolor="#F0F0F0">
									<font color="#0066CC"><b>총 합계금액</font></b> : 상품대금(132,000원) + 배송료(2,500원) = <font color="#FF3333"><b>134,500원</b></font>&nbsp;&nbsp
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
			<!-- form2 끝  -->
			<table width="710" border="0" cellpadding="0" cellspacing="0" class="cmfont">
				<tr height="44">
					<td width="710" align="center" valign="middle">
						<a href="index.html"><img src="../img/b_shopping.gif" border="0"></a>&nbsp;&nbsp;
						<a href="javascript:cart_edit('deleteall',0)"><img src="../img/b_cartalldel.gif" width="103" height="26" border="0"></a>&nbsp;&nbsp;
						<a href="order.html"><img src="../img/b_order1.gif" border="0"></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
    <?php
    include '../footer.php';
    ?>
</body>
</html>
