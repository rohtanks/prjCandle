<?php
include_once '../../dbConfig.php';
$sql_select_member = "SELECT * FROM member ORDER BY mem_id DESC";
$selectResult = mysqli_query($conn, $sql_select_member);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<tr>
			<th>mem_id</th>
			<th>이름</th>
			<th>아이디</th>
			<th>이메일</th>
			<th>비밀번호?</th>
			<th>휴대폰 번호</th>
			<th>주소</th>
			<th>가입일</th>
			<th>정보 수정일</th>
		</tr>
		<?php 
		while ($row = mysqli_fetch_assoc($selectResult)) {
		?>
		<tr>
			<td><?=$row['mem_id']?></td>
			<td><?=$row['mem_name']?></td>
			<td><?=$row['mem_nickname']?></td>
			<td><?=$row['mem_email']?></td>
			<td><?=$row['mem_pw']?></td>
			<td><?=$row['mem_phoneNum']?></td>
			<td><?=$row['mem_addr']?></td>
			<td><?=$row['mem_created_datetime']?></td>
			<td><?=$row['mem_updated_datetime']?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>