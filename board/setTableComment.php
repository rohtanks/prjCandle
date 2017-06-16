<?php
include '../dbConfig.php';

// 댓글 테이블 생성
$sql_create_comment = "CREATE TABLE `comment` (
   `co_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `brd_id` INT(11) UNSIGNED NOT NULL,
   `co_order` INT(11) UNSIGNED DEFAULT 0,
   `co_writer` VARCHAR(20) NOT NULL,
   `co_content` TEXT NOT NULL,
   `co_created_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `co_updated_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `co_like` INT(11) UNSIGNED NOT NULL DEFAULT 0,
   PRIMARY KEY (`co_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// 테이블 삭제
$sql_drop_comment= "DROP TABLE IF EXISTS `comment`";

// 필드 삭제 시
// $sql_alter_comment= "ALTER TABLE comment DROP COLUMN 필드명";

// 필드 추가 시
// $sql_alter_comment= "ALTER TABLE comment ADD 필드명 타입()";

// 필드명 타입 변경 시
// $sql_alter_comment= "ALTER TABLE comment CHANGE 필드명 변환필드명 타입()";

// 타입 변경 시
// $sql_alter_comment= "ALTER TABLE comment MODIFY 필드명 변환타입()";

$result = mysqli_query($conn, $sql_create_comment);
var_dump($result);
if ($result)
	echo "테이블 생성 완료<br>";
	
mysqli_close($conn);
?>