<?php
if(!isset($_SESSION)){
     session_start();
}
$login_user = $_SESSION['login_user'];

include '../dbConfig.php';
include '../common.php';

// mode 프로퍼티를 통해 글 쓰기인지 수정하기인지 알아본다
$mode = $_GET['mode'];
?>
	<div class="container">
		<div class="row">
            <div class="box">
                <div class="col-lg-12">
                	<hr>
                    <h2 class="intro-text text-center">
                        <strong>글쓰기</strong>
                    </h2>
                    <hr>
                    <div class="panel panel-default">
						<div align="right"><?php echo $login_user?></div>
						<div class="panel-body">
							<div class="table-responsive">
							<?php
							// 글 쓰기
							if ($mode == 'write') {
							?>
								<form role="form" action="../board/writeOk.php?mode=<?= $mode ?>" method="post"
										accept-charset="utf-8">
									<div class="form-group">	
										<table class="table table-striped table-bordered table-hover">
											<tbody>
												<tr>
													<th>제목</th>
													<td><input type="text" name="brd_title" class="form-control" /></td>
												</tr>
												<tr>
													<th>분류</th>
													<td>
														<select name="brd_cate" class="form-control">
															<option value="1">상품문의</option>
															<option value="2">인생상담</option>
															<option value="3">연예상담</option>
														</select>
													</td>
												</tr>
												<tr>
													<th>내용</th>
													<td><textarea name="brd_content" class="form-control" rows="3"></textarea></td>
												</tr>
												<tr>
													
														<th>업로드 파일</th>
														<td><input type="file" name="brd_photo" class="form-control" value="사진 업로드"/></td>
												</tr>
										<!-- 		<input type="button" name="" value="파일 업로드"/><br> -->
												<tr>
													<th>비밀글 여부</th>
													<td><input type="checkbox" name="brd_secret" value="1"/> 비밀글을 위한 체크</td>
												</tr>
											</tbody>
										</table>										
									</div>
									<!-- /.form-group -->
									<div>
										<button type="submit" class="btn btn-default">작성완료</button>
										<!-- 버튼 누를 시 자바스크립트 실행되어 이전 페이지로 돌아감 -->
										<button class="btn btn-default" onclick="history.back(); return false;">취소</button> <!-- IE에서 button태그에서 history.back()은 안먹힘 오동작,
																											history.back()에 return false를 주면 정상 동작
																											input태그는 또 먹힘 -->
									</div>
								</form>
						<?php
						// 수정하기
						} else if ($mode == 'modify') {
							$id = $_GET['id'];
							$sql_select_modify = "SELECT * FROM board WHERE brd_id = '".$id."'";
							$result = mysqli_query($conn, $sql_select_modify);
							$row = mysqli_fetch_assoc($result);
						?>
							<form role="form" action="<?=$domainName?>prjcandle/board/writeOk.php?id=<?= $id ?>&mode=<?= $mode ?>" method="post"
									accept-charset="utf-8">
								<div class="form-group">	
									<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<th>제목</th>
												<td><input type="text" name="brd_title" class="form-control" value="<?= $row['brd_title'] ?>" /></td>
											</tr>
											<tr>
												<th>분류</th>
												<td>
													<select name="brd_cate" class="form-control"> <!-- TODO 가져온 값과 비교해서 selected --> 
														<option value="1">상품문의</option>
														<option value="2">인생상담</option>
														<option value="3">연예상담</option>
													</select>
												</td>
											</tr>
											<tr>
												<th>내용</th>
												<td><textarea name="brd_content" class="form-control" rows="3"><?= $row['brd_content'] ?></textarea></td>
											</tr>
											<tr>
												<th>업로드 파일</th>
												<td><input type="file" name="brd_photo" class="form-control" value="사진 업로드"/></td>
											</tr>
										<!-- 		<input type="button" name="" value="파일 업로드"/><br> -->
											<tr>
												<th>비밀글 여부</th>
												<td><input type="checkbox" name="brd_secret" value="1"/> 비밀글을 위한 체크</td>
											</tr>
										</tbody>
									</table>										
								</div>
								<!-- /.form-group -->
								<div>
									<button type="submit" class="btn btn-default">작성완료</button>
									<button class="btn btn-default" onclick="history.back(); return false;">취소</button>
								</div>
							</form>
						<?php
						}
						?>
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel panel-default -->
            </div>
            <!-- /.col-lg-6 -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.row -->
	</div>
    <!-- /.container -->
<?php
include '../footer.php';
?>
</body>
</html>