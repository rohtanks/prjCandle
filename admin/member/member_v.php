<?php
///// 회원 상세 정보 조회/수정 페이지 /////
include '../common.php';
include '../../dbConfig.php';

if (isset ( $_POST ['mem_id'] )) {
	$mem_id = $_POST ['mem_id'];
}

$sql_search_member = "SELECT * FROM member WHERE mem_id = " . $mem_id;
$result = mysqli_query ( $conn, $sql_search_member );
// $tmp = mysqli_fetch_assoc ( $result );
?>
	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">회원 상세 정보</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-6">
				<div class="panel panel-default">
					<?php
					if (isset ( $result )) {
						while ( $row = mysqli_fetch_assoc ( $result ) ) {
					?>
					<div class="panel-heading">
					<?=$row['mem_name']?>님 상세 정보
	                </div>
					<!-- /.panel-heading -->
					<div class="panel-body">
						<div class="table-responsive">
							<form action='<?php echo $PHP_SELF; ?>' method="post" id="s_form">
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<th>* 아이디</th>
										<td><input name="mem_nickname" type="text" id="mem_nickname"
											value="<?= $row['mem_nickname']?>" readonly="readonly"></td>
									</tr>
									<tr>
										<th>* 패스워드</th>
										<td colspan="3"><input name="mem_pw" type="text" id="mem_pw"
											value="<?= $row['mem_pw']?>"> <input name="init_pw"
											type="checkbox" id="init_pw" value="1"> 패스워드 초기화</td>
									</tr>
									<tr>
										<th>* 이 름</th>
										<td><input name="mem_name" type="text" id="name"
											value="<?= $row['mem_name']?>"></td>
										<th>* 메일수신여부</th>
										<td><input type="radio" name="mailreceive" value="1"> 받음 <!-- $list["mailreceive"] == "1" ? " checked":""; -->
											<input type="radio" name="mailreceive" value="0"> <!-- $list["mailreceive"] == "0" ? " checked":""; -->
											받지않음</td>
									</tr>
									<tr>
										<th>* E-mail</th>
										<td colspan="3"><input name="mem_email" type="text"
											id="mem_email" value='<?= $row['mem_email']?>'> <span
											class="button bull"><a href="mailto:<?= $row['mem_email']?>">메일보내기</a></span></td>
									</tr>
									<tr>
										<th>휴대전화 번호</th>
										<td colspan="3"><input name="tel2" type="text"
											value='<?= $row['mem_phoneNum']?>'></td>
									</tr>
									<tr>
										<th>우편번호</th>
									</tr>
									<tr>
										<th>주소</th>
									</tr>
									<tr>
										<th>* 회원등급</th>
										<td><select name='mgrade'>
										</select></td>
									</tr>
								</table>
								<table class="table table-striped table-bordered table-hover">
									<tr>
										<th>경험치</th>
										<td><a href="javascript:getpointInfo('<?= $mem_id?>', 1)"></a>
										</td>
										<th>머니</th>
										<td><a href="javascript:getpointInfo('<?= $mem_id?>', 1)"><span
												id="point_str"></span> POINT</a></td>
									</tr>
									<tr>
										<th>사유</th>
										<td><input type="text" name="exp_cont" id="exp_cont"></td>
										<th>사유</th>
										<td><input type="text" name="point_cont" id="point_cont"></td>
									</tr>
									<tr>
										<th>경험치추가</th>
										<td><input name="exp_value" type="text" id="exp_value"
											class="w30 agn_r"> <input type="button" name="button"
											id="button" value="확인" onClick="insertpoint('exp')"></td>
										<th>머니추가</th>
										<td><input name="point_value" type="text" id="point_value"
											class="w30 agn_r"> <input type="button" name="button"
											id="button" value="확인" onClick="insertpoint('point')"></td>
									</tr>
								</table>
								<div class="btn_box">
									<span class="btn_save button bull"><a>수정</a></span> <span
										class="button bull"><a href="javascript:window.print()">출력</a></span>
									<span class="button bull"><a href="javascript:history.back();">목록보기</a></span>
								</div>
								
							</form>
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.panel-body -->
					<?php
						}
					}
					mysqli_close($conn);
					?>
				</div>
				<!-- /.panel panel-default -->
			</div>
			<!-- /.col-lg-6 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
<!-- wrapper div까지 닫자! -->
</div>
<!-- /#wrapper -->
<?php
include '../footer.php';
?>
</body>
</html>