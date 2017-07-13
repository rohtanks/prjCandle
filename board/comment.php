<?php
include '../dbConfig.php';

$login_user = (isset($_SESSION['login_user'])) ? $_SESSION['login_user'] : null;
$brd_id = (isset($_GET['brd_id'])) ? $_GET['brd_id'] : null;
$co_id = (isset($_GET['co_id'])) ? $_GET['co_id'] : null;
$sql_select_comment = "SELECT * FROM comment WHERE co_id = co_order and brd_id = " . $id . " ORDER BY co_id DESC"; // $id는 원 게시글의 번호, co_id와 co_order가 같은 글이 1Depth의 댓글 co_id가 co_order와 다르다면 2Depth
$result_comment = mysqli_query ( $conn, $sql_select_comment );

?>
<script src="https://code.jquery.com/jquery-3.2.1.js"
	integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
	crossorigin="anonymous"></script>

<?php 
if ($login_user) {
?>
<div id="commentInput">
	<div class="commentTxt">
		<form role="form" action="./commentWriteOk.php" method="post">
			<input type="hidden" name="brd_id" value="<?=$row['brd_id']?>" />
			<table class="table table-hover">
	        	<tr>
	          		<td>
	                	<div>
	                		상대에게 상처를 줄 수 있는 댓글은 삼가해 주세요.<br>
	                		직접적인 욕설 및 인격모독성 발언을 할 경우 제재가 될 수 있습니다.
	                	</div>
	                </td>
	        	</tr>
	        	<tr>
	                <td>
	                	<textarea name="co_content" id="co_content" class="form-control" rows="3"></textarea> <!-- 혹시나 있을 비로그인 상황 위해 클릭시 로그인 체크 경고 -->
	                 	<input type="submit" id="co_submit" class="btn btn-default" value="저장" /> <!-- 이것 또한 클릭시 로그인 이후 이용 가능합니다 란 경고창 -->
	                </td>
	        	</tr>
			</table>
		</form>
	</div>
</div>
<?php 
}
?>
<div id="commentView">
	<form role="form" action="./commentWriteOk.php" method="post">
		<div class="form-group">
		<input type="hidden" name="brd_id" value="<?=$id?>" />
		<?php
		while ( $row = mysqli_fetch_assoc ( $result_comment ) ) {
		?>
		<ul class="oneDepth">
			<li>
				<div id="co_<?=$row['co_id']?>" class="commentSet"> <!-- 이 댓글의 co_id가 몇인지 알 수 있게 -->
					<div class="commentInfo">
						<div class="commentId">
							<span class="coWriter"><?=$row['co_writer']?></span>
							<span class="coDatetime"><?=$row['co_created_datetime']?></span>
						</div>
						<div class="commentBtn">
						<?php 
						if ($login_user) {
						?>
							<a href="javascript:;" class="comt write">댓글</a>
							<?php 
							if ($login_user === $row['co_writer']) { // 수정과 삭제는 댓글 작성자와 로그인 유저가 같을 경우만 노출
							?>
							<a href="javascript:;" class="comt modify">수정</a>
							<a href="javascript:;" class="comt delete">삭제</a>
							<?php 
							}
							?>
						<?php 
						}
						?>
						</div>
					</div>
					<div class="commentContent"><?=$row['co_content']?></div> <!-- 주의 줄을 나누면 글 내용에 공백이 포함된다 -->
				</div>
				<?php
				// 2Depth 댓글 출력
				$sql_select_comment2 = "SELECT * FROM comment WHERE co_id != co_order and co_order = " . $row ['co_id'];
				$result_comment2 = mysqli_query ( $conn, $sql_select_comment2 );
		
				while ( $row2 = mysqli_fetch_assoc ( $result_comment2 ) ) {
				?>
				<ul class="twoDepth">
					<li>
						<div id="co_<?=$row2['co_id']?>" class="commentSet">
							<div class="commentInfo">
								<div class="commentId">
									<span class="coWriter"><?=$row2['co_writer']?></span>
									<span class="coDatetime"><?=$row2['co_created_datetime']?></span>
								</div>
								<div class="commentBtn">
								<?php 
								if ($login_user && $login_user === $row2['co_writer']) {
								?>
									<a href="javascript:;" class="comt modify">수정</a>
									<a href="javascript:;" class="comt delete">삭제</a>
								<?php 
								}
								?>
								</div>
							</div>
							<div class="commentContent"><?=$row2['co_content']?></div> <!-- 주의 줄을 나누면 글 내용에 공백이 포함된다 -->
						</div>
					</li>
				</ul>
				<?php
				}
				?>
			</li>
		</ul>
		<?php
		}
		?>
		</div>
	</form>
</div>
<script>
	$(function () {
		var action = '';
		var commentInput = $('#commentInput');
		if (commentInput) {
			commentInput.find('.commentTxt').addClass('active');
		}

		$('#commentView').on('click', '.comt', function () { // delegate가 on으로 대체되었다 한다
			//상단의 댓글 입력창 삭제
			commentInput.find('.commentTxt').removeClass('active').end().hide();
			
			//현재 위치에서 가장 가까운 commentSet 클래스를 변수에 넣는다.
			var thisParent = $(this).parents('.commentSet');

			//현재 작성 내용을 변수에 넣고, active 클래스 추가.
			var commentSet = thisParent.html();
			thisParent.addClass('active');
			
			//취소 버튼
			var commentBtn = '<a href="javascript:;" class="addComt cancel">취소</a>';
				
			//버튼 삭제 & 추가
			$('.comt').hide();
			$(this).parents('.commentBtn').append(commentBtn);
			
			
			//commentInfo의 ID를 가져온다.
			var co_id = thisParent.attr('id');
			
			//전체 길이에서 3("co_")를 뺀 나머지가 co_id
			co_id = co_id.substr(3, co_id.length);
			
			//변수 초기화
			var comment = '';
			var coWriter = '';
			var coContent = '';
			
			if($(this).hasClass('write')) {
				//댓글 쓰기
				action = 'w';
			
			} else if($(this).hasClass('modify')) {
				//댓글 수정
				action = 'm';				
				
				var coContent = thisParent.find('.commentContent').text();
				
			} else if($(this).hasClass('delete')) {
				//댓글 삭제	
				action = 'd';
			}

				comment += '<div class="writeComment form-group">';
				comment += '	<input type="hidden" name="w" value="' + action + '">';
				comment += '	<input type="hidden" name="co_id" value="' + co_id + '">';
				comment += '	<table class="table table-hover">';
				comment += '		<tbody>';
				if(action !== 'd') {
					comment += '			<tr>';
					comment += '				<td>';
					comment += '					<div>';
					comment += '						상대에게 상처를 줄 수 있는 댓글은 삼가해 주세요.<br>';
					comment += '						직접적인 욕설 및 인격모독성 발언을 할 경우 제재가 될 수 있습니다.';
					comment += '					</div>';
					comment += '				</td>';
					comment += '			</tr>';
					comment += '			<tr>';
					comment += '				<td colspan="5">';
					comment += '					<textarea name="co_content" id="co_content" class="form-control" rows="3">'+coContent+'</textarea>';
					comment += '				</td>';
					comment += '			</tr>';
				}
				comment += '		</tbody>';
				comment += '	</table>';
				comment += '	<div class="btnSet form-group">';
				comment += '		<input type="submit" class="btn btn-default" value="확인">';
				comment += '	</div>';
				comment += '</div>';
			
				thisParent.after(comment);
		});
		
		$('#commentView').on('click', '.cancel', function () {
				$('.writeComment').remove();
				$('.commentSet.active').removeClass('active');
				$('.addComt').remove();
				$('.comt').show();
				commentInput.find('.commentTxt').addClass('active').end().show();
		});
	});
</script>