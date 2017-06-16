<?php
?>
<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
	<div>
		<form action="<?=$domainName?>prjCandle/board/commentWriteOk.php?mode=write" method="post">
			<input type="hidden" name="" value="<?=$row['brd_id']?>" />
			<input type="text" name="" value="<?=$login_user?>" />
			<table>
            	<tr>
              		<td>
                    	<div>
                    		상대에게 상처를 줄 수 있는 댓글은 삼가주세요.<br>
                    		직접적인 욕설 및 인격모독성 발언을 할 경우 제재가 될 수 있습니다.
                    	</div>
                    </td>
                	<td>
						<label id="btn_imageUpload" for="image-upload"><b>- 이미지추가</b></label> <!-- 클릭 이벤트 이미지추가 -->
					</td>
            	</tr>
            	<tr>
                    <td colspan="5">
                    	<textarea name="co_content" class="textarea" id="co_content"></textarea> <!-- 혹시나 있을 비로그인 상황 위해 클릭시 로그인 체크 경고 -->
                     	<input type="button" class="submit_c" value="저장" /> <!-- 이것 또한 클릭시 로그인 이후 이용 가능합니다 란 경고창 -->
                    </td>
            	</tr>
           		<tr id="comment-upload-preview">
            		<td style="padding: 10px 0px 7px;" colspan="4">
              			<input name="image-upload" id="image-upload" style="display: none;" type="file">
              			<input name="comment_uploaded_file" id="comment_uploaded_file" type="hidden" value="">
              			<div class="upload-path" name="upload-path"></div>
              			<div class="file-preview"><i class="btn-remove"></i></div>
            		</td>
           		</tr>
			</table>
		</form>
	</div>
</body>
</html>