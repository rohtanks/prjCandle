<?php
include '../member/dbConfig.php';

// 게시판 테이블 생성
$sql_create_board = "CREATE TABLE `board` (
   `brd_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `brd_cate` VARCHAR(20) NOT NULL,
   `brd_writer` VARCHAR(20) NOT NULL,
   `brd_title` VARCHAR(100) NOT NULL,
   `brd_content` TEXT NOT NULL,
   `brd_photo` VARCHAR(255),
   `brd_secret` TINYINT(4) UNSIGNED NOT NULL,
   `brd_created_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `brd_updated_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   `brd_like` INT(11) UNSIGNED NOT NULL DEFAULT 0,
   `brd_check` INT(11) UNSIGNED NOT NULL DEFAULT 0,
   PRIMARY KEY (`brd_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// 필드 삭제 시
// $sql_alter_board = "ALTER TABLE board DROP COLUMN 필드명";

// 필드 추가 시
// $sql_alter_board = "ALTER TABLE board ADD 필드명 타입()";

// 필드명 타입 변경 시
// $sql = "ALTER TABLE board CHANGE 필드명 변환필드명 타입()";

// 타입 변경 시
// $sql = "ALTER TABLE board MODIFY 필드명 변환타입()";

mysqli_query($conn, $sql_create_board);

mysqli_close($conn);
?>