<?php
error_reporting(0);
include '../common.php';
include '../dbConfig.php';
 ?>

<body style="margin:0">

<form name="form1" method="post" action="product_insert.html" enctype="multipart/form-data">

<center>

<br>
<script> document.write(menu());</script>
<br>
<br>

<table width="800" border="1" cellpadding="2" style="border-collapse:collapse">
	<tr height="23">
		<td width="100" bgcolor="#CCCCCC" align="center">상품분류</td>
		<td width="700" bgcolor="#F2F2F2">
			<select name="menu">
				<option value="0" selected>상품분류를 선택하세요</option>
				<option value="1">바지</option>
				<option value="2">코트</option>
				<option value="3">브라우스</option>
			</select>
		</td>
	</tr>
	<tr height="23">
		<td width="100" bgcolor="#CCCCCC" align="center">상품코드</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="text" name="code" value="" size="20" maxlength="20">
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">상품명</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="text" name="name" value="" size="60" maxlength="60">
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">제조사</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="text" name="coname" value="" size="30" maxlength="30">
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">판매가</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="text" name="price" value="" size="12" maxlength="12"> 원
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">옵션</td>
    <td width="700" bgcolor="#F2F2F2">
			<select name="opt1">
				<option value="0" selected>옵션선택</option>
				<option value="1">사이즈</option>
				<option value="2">색상_WB</option>
				<option value="3">색상_WR</option>
			</select> &nbsp; &nbsp;

			<select name="opt2">
				<option value="0" selected>옵션선택</option>
				<option value="1">사이즈</option>
				<option value="2">색상_WB</option>
				<option value="3">색상_WR</option>
			</select> &nbsp; &nbsp;
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">제품설명</td>
		<td width="700" bgcolor="#F2F2F2">
			<textarea name="contents" rows="10" cols="80"></textarea>
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">상품상태</td>
    <td width="700" bgcolor="#F2F2F2">
			<input type="radio" name="status" value="1" checked> 판매중
			<input type="radio" name="status" value="2"> 판매중지
			<input type="radio" name="status" value="3"> 품절
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">아이콘</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="checkbox" name="icon_new" value="1"> New &nbsp;&nbsp
			<input type="checkbox" name="icon_hit" value="1"> Hit &nbsp;&nbsp
			<input type="checkbox" name="icon_sale" value="1"> Sale &nbsp;&nbsp
			할인율 : <input type="text" name="discount" value="0" size="3" maxlength="3"> %
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">등록일</td>
		<td width="700" bgcolor="#F2F2F2">
			<input type="text" name="regday1" value="" size="4" maxlength="4"> 년 &nbsp
			<input type="text" name="regday2" value="" size="2" maxlength="2"> 월 &nbsp
			<input type="text" name="regday3" value="" size="2" maxlength="2"> 일
		</td>
	</tr>
	<tr>
		<td width="100" bgcolor="#CCCCCC" align="center">이미지</td>
		<td width="700" bgcolor="#F2F2F2">
			<b>이미지1</b>: <input type="file" name="image1" size="30" value="찾아보기"><br>
			<b>이미지2</b>: <input type="file" name="image2" size="30" value="찾아보기"><br>
			<b>이미지3</b>: <input type="file" name="image3" size="30" value="찾아보기"><br>
		</td>
	</tr>
</table>

<table width="800" border="0" cellspacing="0" cellpadding="7">
	<tr>
		<td align="center">
			<input type="submit" value="등록하기"> &nbsp;&nbsp
			<input type="button" value="이전화면" onClick="javascript:history.back();">
		</td>
	</tr>
</table>

</form>

</center>

</body>
</html>
