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
		<td width="100" bgcolor="#CCCCCC" align="center">이미지</td>
		<td width="700"  bgcolor="#F2F2F2">

			<table border="0" cellspacing="0" cellpadding="0" align="left">
				<tr>
					<td>
						<table width="390" border="0" cellspacing="0" cellpadding="0">
              <?php
              // 업로드 파일 갯수 지정($num) : 여기서는 3개로 지정함
              for ($num = 1 ; $num <= 3 ; $num++) {
                      $hiddenfile = "imagename".$num;
                      $selectfile = "image".$num;
                      $checkno = "checkno".$num; // input 태그의 name 속성 값을 inputname1, inputname2, inputname3으로 설정하기 위함
              ?>
							<tr>
								<td>
                  					<input type='hidden' name='<?$hiddenfile?>' value='s001_1.jpg'>
									&nbsp;<input type="checkbox" name="<?$checkno?>" value="1"> <b><?php echo $selectfile ?></b>
									<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="file" name="<?$selectfile?>" size="20">
								</td>
							</tr>
              <?php
          	  }
              ?>
							<tr>	
								<td><br>&nbsp;&nbsp;&nbsp;※ 삭제할 그림은 체크를 하세요.</td>
							</tr>
				  	</table>
						<br><br><br><br><br>
						<table width="390" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td  valign="middle">&nbsp;
									<img src="<?$selectfile.value?>" width="50" height="50" border="1" style='cursor:hand' onclick="imageView('')">&nbsp;
									<img src="" width="50" height="50" border="1" style='cursor:hand' onclick="imageView('')">&nbsp;
									<img src=""  width="50" height="50" border="1" style='cursor:hand' onclick="imageView('')">&nbsp;
								</td>
							</tr>
						</table>
					</td>
					<td>
						<td align="right" width="310"><img name="big" src="" width="300" height="300" border="1"></td>
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>


<table width="800" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td align="center">
			<input type="submit" value="수정하기" onclick="javascript:return confirm('수정할까요?');"> &nbsp;&nbsp
			<input type="button" value="이전화면" onClick="javascript:history.back();">
		</td>
	</tr>
</table>

</form>

</center>

</body>
</html>
