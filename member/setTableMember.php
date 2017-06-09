<?php
include '../dbConfig.php';

// 디비 생성
$sql_create_db = "CREATE DATABASE prjCandle CHARACTER SET utf8 COLLATE utf8_GENERAL_CI";

// 회원 테이블 생성
$sql_create_member = "CREATE TABLE `member` (
   `mem_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
   `mem_name` VARCHAR(20) NOT NULL,
   `mem_nickname` VARCHAR(20) NOT NULL,
   `mem_email` VARCHAR(50) NOT NULL,
   `mem_pw` VARCHAR(255) NOT NULL,
   `mem_phoneNum` VARCHAR(11) NOT NULL,
   `mem_addr` VARCHAR(255) NOT NULL,
   `mem_created_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP,
   `mem_updated_datetime` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`mem_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// 테이블 삭제
$sql_drop_member = "DROP TABLE `member`";

// 필드 삭제 시
// $sql_alter_member = "ALTER TABLE member DROP COLUMN 필드명";

// 필드 추가 시
// $sql_alter_member = "ALTER TABLE member ADD 필드명 타입()";

// 필드명 타입 변경 시
// $sql_alter_member= "ALTER TABLE memberCHANGE 필드명 변환필드명 타입()";

// 타입 변경 시
// $sql_alter_member= "ALTER TABLE memberMODIFY 필드명 변환타입()";

$result = mysqli_query($conn, $sql_create_member);
$row = mysqli_fetch_assoc($result);
echo $row;
mysqli_close($conn);
?>