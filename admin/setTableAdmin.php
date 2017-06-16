<?php
include '../dbConfig.php';

// 회원 테이블 생성
$sql_create_admin = "CREATE TABLE `admin` (
   `ad_id` VARCHAR(20) NOT NULL,
   `ad_pw` VARCHAR(255) NOT NULL,
   `ad_level` TINYINT(4) UNSIGNED NOT NULL,
   PRIMARY KEY (`ad_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

// 최초에 한번 실행하여 admin 계정을 생성한 후
// 최초 로그인 시 비밀번호를 변경하도록 유도한다
$sql_insert_admin = "INSERT INTO `admin` VALUES ('admin', 'cookie1212', 1)";

// 테이블 삭제
$sql_drop_admin = "DROP TABLE IF EXISTS `admin`";

// 필드 삭제 시
// $sql_alter_admin= "ALTER TABLE admin DROP COLUMN 필드명";

// 필드 추가 시
// $sql_alter_admin= "ALTER TABLE admin ADD 필드명 타입()";

// 필드명 타입 변경 시
// $sql_alter_admin= "ALTER TABLE admin CHANGE 필드명 변환필드명 타입()";

// 타입 변경 시
// $sql_alter_admin= "ALTER TABLE admin MODIFY 필드명 변환타입()";

$result = mysqli_query($conn, $sql_create_admin);
var_dump($result);
if ($result)
	echo "테이블 생성 완료<br>";
	
$insert_result = mysqli_query($conn, $sql_insert_admin);
if ($insert_result)
	echo "admin 계정 생성 완료";
	
mysqli_close($conn);
?>