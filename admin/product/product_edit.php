<?php
error_reporting(0);
$no= $_GET['no'];
$sel1= $_GET['sel1'];
$text1= $_GET['text1'];
$img1= $_GET['img1'];
$img2= $_GET['img2'];
$img3= $_GET['img3'];

include '../common.php';
include '../dbConfig.php';
 ?>

<body style="margin:0">

<form name="form1" method="post" action="product_update.php?no=<?=$no?>" enctype="multipart/form-data">

<input type="hidden" name="sel1" value="">
<input type="hidden" name="sel2" value="">
<input type="hidden" name="sel3" value="">
<input type="hidden" name="sel4" value="">
<input type="hidden" name="text1" value="">
<input type="hidden" name="page" value="1">
<input type="hidden" name="no" value="1">

<center>

<br>
<script> document.write(menu());</script>
<br>
<br>

<table width="800" border="1" cellpadding="2" style="border-collapse:collapse">
	<tr height="23">
		<td width="100" bgcolor="#CCCCCC" align="center">상품번호</td>
		<td width="700"  bgcolor="#F2F2F2">
			<input type="text" name="code" value="<?= $no?>" size="20" maxlength="20">
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">상품명</td>
		<td width="700"  bgcolor="#F2F2F2">
			<input type="text" name="name" value="<?= $sel1?>" size="60" maxlength="60">
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">판매가</td>
		<td width="700"  bgcolor="#F2F2F2">
			<input type="text" name="price" value="<?= $text1?>" size="12" maxlength="12"> 원
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">옵션</td>
		<td width="700"  bgcolor="#F2F2F2">
			<select name="opt1">
				<option value="0">옵션선택</option>
				<option value="1" selected>사이즈</option>
				<option value="2">색상_WB</option>
				<option value="3">색상_WR</option>
			</select> &nbsp; &nbsp;

			<select name="opt2">
				<option value="0">옵션선택</option>
				<option value="1">사이즈</option>
				<option value="2" selected>색상_WB</option>
				<option value="3">색상_WR</option>
			</select> &nbsp; &nbsp;
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">제품설명</td>
		<td width="700"  bgcolor="#F2F2F2">
			<textarea name="contents" rows="4" cols="70">좋은 상품</textarea>
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">상품상태</td>
    <td width="700"  bgcolor="#F2F2F2">
			<input type="radio" name="status" value="1" checked> 판매중
			<input type="radio" name="status" value="2"> 판매중지
			<input type="radio" name="status" value="3"> 품절
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">아이콘</td>
		<td width="700"  bgcolor="#F2F2F2">
			<input type="checkbox" name="icon_new" value="1"> New &nbsp;&nbsp
			<input type="checkbox" name="icon_hit" value="1" checked> Hit &nbsp;&nbsp
			<input type="checkbox" name="icon_sale" value="1"> Sale &nbsp;&nbsp
			할인율 : <input type="text" name="discount" value="10" size="3" maxlength="3"> %
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">등록일</td>
		<td width="700"  bgcolor="#F2F2F2">
			<input type="text" name="regday1" value="2007" size="4" maxlength="4"> 년 &nbsp
			<input type="text" name="regday2" value="01" size="2" maxlength="2"> 월 &nbsp
			<input type="text" name="regday3" value="01" size="2" maxlength="2"> 일 &nbsp
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">이미지</td>
		<td width="700"  bgcolor="#F2F2F2">

			<table border="0" cellspacing="0" cellpadding="0" align="left">
				<tr>
					<td>
						<table width="390" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<input type='hidden' name='imagename1' value='<?= $img1?>'>
									&nbsp;<input type="checkbox" name="checkno1" value="1"> <b>이미지1</b>: s001_1.jpg
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="file" name="image1" size="20" value="찾아보기">
								</td>
							</tr>
							<tr>
								<td>
									<input type='hidden' name='imagename2' value='<?= $img2?>'>
									&nbsp;<input type="checkbox" name="checkno2" value="1"checked> <b>이미지2</b>: s001_2.jpg
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="file" name="image2" size="20" value="찾아보기">
								</td>
							</tr>
							<tr>
								<td>
									<input type='hidden' name='imagename3' value='<?= $img3?>'>
									&nbsp;<input type="checkbox" name="checkno3" value="1"> <b>이미지3</b>:
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="file" name="image3" size="20" value="찾아보기">
								</td>
							</tr>
							<tr>
								<td><br>&nbsp;&nbsp;&nbsp;※ 삭제할 그림은 체크를 하세요.</td>
							</tr>
				  	</table>
						<br><br><br><br><br>
						<table width="390" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td  valign="middle">&nbsp;
									<img src="<?= $img1?>" width="50" height="50" border="1" style='cursor:hand' onclick="imageView('<?= $img1?>')">&nbsp;
									<img src="<?= $img2?>" width="50" height="50" border="1" style='cursor:hand' onclick="imageView('<?= $img2?>')">&nbsp;
									<img src="<?= $img3?>"  width="50" height="50" border="1" style='cursor:hand' onclick="imageView('<?= $img3?>')">&nbsp;
								</td>
							</tr>
						</table>
					</td>
					<td>
						<td align="right" width="310"><img name="big" src="../product/s001_1.jpg" width="300" height="300" border="1"></td>
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>

<table width="800" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="center">
			<input type="submit" value="수정하기"> &nbsp;&nbsp
			<input type="button" value="이전화면" onClick="javascript:history.back();">
		</td>
	</tr>
</table>

</form>

</center>

</body>
</html>
